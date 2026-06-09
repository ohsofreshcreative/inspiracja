<?php

/**
 * WooCommerce Booking System
 * System rezerwacji z kalendarzem i wyborem godzin
 */

// Dodaj zmienne AJAX do HEAD
function add_booking_ajax_vars()
{
    if (is_product()) {
        ?>
        <script type="text/javascript">
            window.bookingAjax = {
                ajax_url: '<?php echo admin_url('admin-ajax.php'); ?>',
                nonce: '<?php echo wp_create_nonce('booking_nonce'); ?>'
            };
        </script>
        <?php
    }
}
add_action('wp_head', 'add_booking_ajax_vars');

// Wyświetl formularz rezerwacji na stronie produktu
add_action('woocommerce_before_add_to_cart_button', 'display_booking_form');

function display_booking_form()
{
    global $product;
    
    $product_id = $product->get_id();
    $enable_booking = get_field('enable_booking', $product_id);
    
    if (!$enable_booking) {
        return;
    }
    
    $available_hours = get_field('available_hours', $product_id);
    $min_hours = get_field('booking_duration_min', $product_id) ?: 2;
    $max_hours = get_field('booking_duration_max', $product_id) ?: 8;
    $max_days = get_field('excluded_days', $product_id) ?: 30;
    $base_price = $product->get_price();
    
    // Przygotuj listę godzin
    $hours_list = [];
    if ($available_hours && is_array($available_hours)) {  
        foreach ($available_hours as $hour) {
            if (isset($hour['hour'])) {
                $hours_list[] = $hour['hour'];
            }
        }
    }
    
    // Jeśli brak godzin, ustaw domyślne (9:00 - 17:00)
    if (empty($hours_list)) {
        for ($h = 9; $h <= 17; $h++) {
            $hours_list[] = sprintf('%02d:00', $h);
        }
    }
    
    ?>
  <div class="booking-system bg-white p-6 rounded-lg border-2 border-gray-200 mb-6 flex flex-col lg:flex-row gap-20 w-full">
    <!--     <h3 class="text-h4 mb-4">Wybierz datę i godziny rezerwacji</h3> -->
        
        <!-- Kalendarz -->
        <div class="w-full">
			<div class="booking-calendar mb-4">
				<label class="block text-sm font-semibold mb-2">Data rezerwacji</label>
				<div id="booking-date"></div>
				<input type="hidden" id="booking-date-hidden" name="booking_date" required />
			</div>
			
			<!-- Wybór godzin -->
			<div class="booking-hours mb-4">
				<label class="block text-sm font-semibold mb-2">
					Wybierz godziny (od - do)
				<span class="text-gray-500 text-xs">(min. 2h)</span>
				</label>
				<div class="hours-grid grid grid-cols-4 md:grid-cols-6 gap-2">
					<?php foreach ($hours_list as $hour): ?>
						<button
							type="button"
							class="hour-slot btn-outline-primary text-sm py-2 px-3 rounded transition-all hover:bg-primary hover:text-white border border-gray-300"
							data-hour="<?php echo esc_attr($hour); ?>"
						>
							<?php echo esc_html($hour); ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
        
        <!-- Podsumowanie -->
       <div class="booking-summary bg-lighter p-10 rounded flex flex-col justify-between">
            <div class="flex flex-col justify-between mb-2">
                <span class="font-semibold">Wybrane godziny:</span>
                <span id="selected-hours-display" class="text-gray-600">Nie wybrano</span>
            </div>
            <div class="flex flex-col justify-between mb-2">
                <span class="font-semibold">Liczba godzin:</span>
                <span id="hours-count" class="text-gray-600">0</span>
            </div>
            <div class="flex flex-col justify-between text-lg mb-4">
                <span class="font-bold">Całkowity koszt:</span>
                <span id="total-price" class="font-bold text-primary"><?php echo wc_price($base_price); ?></span>
            </div>
            
            <!-- Przycisk rezerwacji -->
            <button 
                type="button" 
                id="booking-reserve-btn"
                class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 rounded-lg transition-all duration-200 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                onclick="document.querySelector('.single_add_to_cart_button').click()"
            >
                Zarezerwuj
            </button>
        </div>
        
        <!-- Hidden inputs -->
        <input type="hidden" name="booking_selected_hours" id="booking_selected_hours" value="" />
        <input type="hidden" name="booking_hours_count" id="booking_hours_count" value="0" />
        
        <!-- Data attributes dla JavaScript -->
        <div 
            id="booking-config" 
            data-base-price="<?php echo esc_attr($base_price); ?>"
            data-min-hours="<?php echo esc_attr($min_hours); ?>"
            data-max-hours="<?php echo esc_attr($max_hours); ?>"
            data-max-days="<?php echo esc_attr($max_days); ?>"
            data-product-id="<?php echo esc_attr($product_id); ?>"
            style="display: none;"
        ></div>
    </div>
    <?php
}

// Walidacja przy dodawaniu do koszyka
add_filter('woocommerce_add_to_cart_validation', 'validate_booking_data', 10, 3);

function validate_booking_data($passed, $product_id, $quantity)
{
    $enable_booking = get_field('enable_booking', $product_id);
    
    if (!$enable_booking) {
        return $passed;
    }
    
    if (empty($_POST['booking_date'])) {
        wc_add_notice('Proszę wybrać datę rezerwacji.', 'error');
        return false;
    }
    
    if (empty($_POST['booking_selected_hours'])) {
        wc_add_notice('Proszę wybrać godziny rezerwacji.', 'error');
        return false;
    }
    
    $hours_count = intval($_POST['booking_hours_count']);
    $min_hours = get_field('booking_duration_min', $product_id) ?: 2;
    $max_hours = get_field('booking_duration_max', $product_id) ?: 8;
    
    if ($hours_count < $min_hours) {
        wc_add_notice("Minimalna liczba godzin: {$min_hours}", 'error');
        return false;
    }
    
    return $passed;
}

// Zapisz dane rezerwacji w koszyku
add_filter('woocommerce_add_cart_item_data', 'add_booking_data_to_cart', 10, 2);

function add_booking_data_to_cart($cart_item_data, $product_id)
{
    $enable_booking = get_field('enable_booking', $product_id);
    
    if (!$enable_booking) {
        return $cart_item_data;
    }
    
    if (isset($_POST['booking_date'])) {
        $cart_item_data['booking_date'] = sanitize_text_field($_POST['booking_date']);
    }
    
    if (isset($_POST['booking_selected_hours'])) {
        $cart_item_data['booking_hours'] = sanitize_text_field($_POST['booking_selected_hours']);
    }
    
    if (isset($_POST['booking_hours_count'])) {
        $cart_item_data['booking_hours_count'] = intval($_POST['booking_hours_count']);
    }
    
    return $cart_item_data;
}

// Wyświetl dane rezerwacji w koszyku
add_filter('woocommerce_get_item_data', 'display_booking_data_in_cart', 10, 2);

function display_booking_data_in_cart($item_data, $cart_item)
{
    if (isset($cart_item['booking_date'])) {
        $item_data[] = [
            'key' => 'Data rezerwacji',
            'value' => $cart_item['booking_date'],
        ];
    }
    
    if (isset($cart_item['booking_hours'])) {
        $item_data[] = [
            'key' => 'Godziny',
            'value' => $cart_item['booking_hours'],
        ];
    }
    
    if (isset($cart_item['booking_hours_count'])) {
        $item_data[] = [
            'key' => 'Liczba godzin',
            'value' => $cart_item['booking_hours_count'] . 'h',
        ];
    }
    
    return $item_data;
}

// Zmień cenę w koszyku (bazowa cena × liczba godzin)
add_action('woocommerce_before_calculate_totals', 'calculate_booking_price');

function calculate_booking_price($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    
    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['booking_hours_count'])) {
            $base_price = $cart_item['data']->get_price();
            $hours = intval($cart_item['booking_hours_count']);
            $new_price = $base_price * $hours;
            
            $cart_item['data']->set_price($new_price);
        }
    }
}

// Zapisz dane rezerwacji w zamówieniu
add_action('woocommerce_checkout_create_order_line_item', 'save_booking_data_to_order', 10, 4);

function save_booking_data_to_order($item, $cart_item_key, $values, $order)
{
    if (isset($values['booking_date'])) {
        $item->add_meta_data('Data rezerwacji', $values['booking_date']);
    }
    
    if (isset($values['booking_hours'])) {
        $item->add_meta_data('Godziny', $values['booking_hours']);
    }
    
    if (isset($values['booking_hours_count'])) {
        $item->add_meta_data('Liczba godzin', $values['booking_hours_count'] . 'h');
    }
}

// AJAX: Sprawdź dostępne godziny dla wybranej daty
add_action('wp_ajax_check_booking_availability', 'check_booking_availability');
add_action('wp_ajax_nopriv_check_booking_availability', 'check_booking_availability');

function check_booking_availability()
{
    check_ajax_referer('booking_nonce', 'nonce');
    
    $product_id = intval($_POST['product_id']);
    $date = sanitize_text_field($_POST['date']);
    
    // Pobierz zajęte godziny dla tej daty i produktu
    $booked_hours = get_booked_hours_for_date($product_id, $date);
    
    wp_send_json_success([
        'booked_hours' => $booked_hours,
        'date' => $date,
    ]);
}

// Pobierz zajęte godziny dla konkretnej daty i produktu
function get_booked_hours_for_date($product_id, $date)
{
    global $wpdb;
    
    $booked_hours = [];
    
    // Szukaj w zamówieniach (order items meta)
    $orders = wc_get_orders([
        'limit' => -1,
        'status' => ['completed', 'processing', 'on-hold'], // Tylko opłacone/w trakcie
        'date_created' => '>=' . strtotime('-90 days'), // Ostatnie 90 dni
    ]);
    
    foreach ($orders as $order) {
        foreach ($order->get_items() as $item) {
            $item_product_id = $item->get_product_id();
            $booking_date = $item->get_meta('Data rezerwacji');
            $booking_hours_str = $item->get_meta('Godziny');
            
            // Jeśli to ten sam produkt i ta sama data
            if ($item_product_id == $product_id && $booking_date === $date && !empty($booking_hours_str)) {
                // Parsuj godziny (np. "09:00, 10:00, 11:00")
                $hours_array = array_map('trim', explode(',', $booking_hours_str));
                $booked_hours = array_merge($booked_hours, $hours_array);
            }
        }
    }
    
    return array_unique($booked_hours);
}

// Dodatkowa walidacja przy checkout - sprawdź czy godziny nie zostały zajęte
add_action('woocommerce_after_checkout_validation', 'validate_booking_availability_checkout', 10, 2);

function validate_booking_availability_checkout($data, $errors)
{
    foreach (WC()->cart->get_cart() as $cart_item) {
        if (isset($cart_item['booking_date']) && isset($cart_item['booking_hours'])) {
            $product_id = $cart_item['product_id'];
            $date = $cart_item['booking_date'];
            $requested_hours = explode(', ', $cart_item['booking_hours']);
            
            $booked_hours = get_booked_hours_for_date($product_id, $date);
            
            // Sprawdź czy któraś z wybranych godzin jest już zajęta
            $conflicts = array_intersect($requested_hours, $booked_hours);
            
            if (!empty($conflicts)) {
                $errors->add('booking_conflict', 
                    'Przepraszamy, następujące godziny zostały już zarezerwowane: ' . implode(', ', $conflicts) . '. Proszę wybrać inne godziny.'
                );
            }
        }
    }
}