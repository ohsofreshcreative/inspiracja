import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { Polish } from 'flatpickr/dist/l10n/pl.js';

flatpickr.localize(Polish);

document.addEventListener('DOMContentLoaded', function() {
    const bookingSystem = document.querySelector('.booking-system');
    
    if (!bookingSystem) return;
    
    const config = document.getElementById('booking-config');
    if (!config) return;
    
    const basePrice = parseFloat(config.dataset.basePrice);
    const productId = config.dataset.productId;
    const minHours = parseInt(config.dataset.minHours || '2', 10);
    const maxHours = parseInt(config.dataset.maxHours || '8', 10);
    const maxDays = parseInt(config.dataset.maxDays || '120', 10);
    
    let selectedHours = [];
    let startHour = null;
    let endHour = null;
    let bookedHours = []; // Zajęte godziny dla wybranej daty
    
    // Inicjalizuj kalendarz Flatpickr
    const datePicker = flatpickr('#booking-date', {
        inline: true,
        minDate: new Date().fp_incr(1),
        maxDate: new Date().fp_incr(maxDays),
        dateFormat: 'd-m-Y',
        locale: Polish,
        disable: [
            function(date) {
                // Wyłącz niedziele (0) i soboty (6) opcjonalnie
                // return (date.getDay() === 0 || date.getDay() === 6);
                return false;
            }
        ],
        onChange: function(selectedDates, dateStr) {
            console.log('Wybrana data:', dateStr);
            // Zaktualizuj hidden input
            document.getElementById('booking-date-hidden').value = dateStr;
            // Reset godzin przy zmianie daty
            resetHours();
            // Sprawdź dostępność dla nowej daty
            checkAvailability(dateStr);
        }
    });
    
    // Funkcja sprawdzająca dostępność przez AJAX
    function checkAvailability(date) {
        if (!date || !window.bookingAjax) return;
        
        const formData = new FormData();
        formData.append('action', 'check_booking_availability');
        formData.append('nonce', window.bookingAjax.nonce);
        formData.append('product_id', productId);
        formData.append('date', date);
        
        fetch(window.bookingAjax.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bookedHours = data.data.booked_hours || [];
                updateHourSlots();
            }
        })
        .catch(error => {
            console.error('Błąd sprawdzania dostępności:', error);
        });
    }
    
    // Aktualizuj sloty godzin (wyłącz zajęte)
    function updateHourSlots() {
        const hourSlots = document.querySelectorAll('.hour-slot');
        
        hourSlots.forEach(slot => {
            const hour = slot.dataset.hour;
            
            if (bookedHours.includes(hour)) {
                // Godzina zajęta
                slot.disabled = true;
                slot.classList.add('booked', 'opacity-50', 'cursor-not-allowed', 'bg-gray-200');
                slot.classList.remove('hover:bg-primary', 'hover:text-white');
                slot.title = 'Godzina zajęta';
            } else {
                // Godzina dostępna
                slot.disabled = false;
                slot.classList.remove('booked', 'opacity-50', 'cursor-not-allowed', 'bg-gray-200');
                slot.title = '';
            }
        });
    }
    
    // Obsługa wyboru godzin
    const hourSlots = document.querySelectorAll('.hour-slot');
    
    hourSlots.forEach(slot => {
        slot.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Jeśli godzina zajęta, ignoruj kliknięcie
            if (this.disabled || this.classList.contains('booked')) {
                return;
            }
            
            const hour = this.dataset.hour;
            
            // Pierwszy klik - ustaw start
            if (!startHour) {
                startHour = hour;
                this.classList.add('selected', 'bg-primary', 'text-white', 'border-primary');
                updateSummary();
                return;
            }
            
            // Drugi klik - ustaw koniec i zaznacz wszystkie między
            if (startHour && !endHour) {
                endHour = hour;
                selectRangeHours(startHour, endHour);
                updateSummary();
                return;
            }
            
            // Trzeci klik - reset
            if (startHour && endHour) {
                resetHours();
            }
        });
    });
    
    function selectRangeHours(start, end) {
        selectedHours = [];
        let recording = false;
        let hasBookedInRange = false;
        
        hourSlots.forEach(slot => {
            const hour = slot.dataset.hour;
            
            if (hour === start) recording = true;
            
            if (recording) {
                // Sprawdź czy godzina w zakresie jest zajęta
                if (bookedHours.includes(hour)) {
                    hasBookedInRange = true;
                    return; // Przerwij zaznaczanie jeśli napotkasz zajętą godzinę
                }
                
                slot.classList.add('selected', 'bg-primary', 'text-white', 'border-primary');
                selectedHours.push(hour);
            }
            
            if (hour === end) recording = false;
        });
        
        // Jeśli w zakresie była zajęta godzina, resetuj wybór
        if (hasBookedInRange) {
            alert('Nie można wybrać zakresu z zajętymi godzinami. Proszę wybrać inny zakres.');
            resetHours();
        }
    }
    
    function resetHours() {
        startHour = null;
        endHour = null;
        selectedHours = [];
        
        hourSlots.forEach(slot => {
            if (!slot.classList.contains('booked')) {
                slot.classList.remove('selected', 'bg-primary', 'text-white', 'border-primary');
            }
        });
        
        updateSummary();
    }
    
    function updateSummary() {
        const hoursCount = selectedHours.length;
        const totalPrice = basePrice * hoursCount;
        
        // Aktualizuj wyświetlane informacje
        document.getElementById('selected-hours-display').textContent = 
            selectedHours.length > 0 ? `${selectedHours[0]} - ${selectedHours[selectedHours.length - 1]}` : 'Nie wybrano';
        
        document.getElementById('hours-count').textContent = hoursCount;
        
        // Formatuj cenę
        document.getElementById('total-price').innerHTML = formatPrice(totalPrice);
        
        // Aktualizuj hidden inputs
        document.getElementById('booking_selected_hours').value = selectedHours.join(', ');
        document.getElementById('booking_hours_count').value = hoursCount;
    }
    
    function formatPrice(price) {
        return new Intl.NumberFormat('pl-PL', {
            style: 'currency',
            currency: 'PLN'
        }).format(price);
    }
    
    // Walidacja przed dodaniem do koszyka
    const addToCartBtn = document.querySelector('.single_add_to_cart_button');
    
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(e) {
            const bookingDate = document.getElementById('booking-date-hidden').value;
            
            if (!bookingDate) {
                e.preventDefault();
                alert('Proszę wybrać datę rezerwacji');
                return false;
            }
            
            if (selectedHours.length === 0) {
                e.preventDefault();
                alert('Proszę wybrać godziny rezerwacji');
                return false;
            }
            
            if (selectedHours.length < minHours) {
                e.preventDefault();
                alert(`Minimalna liczba godzin: ${minHours}`);
                return false;
            }
            
           
        });
    }
});