<!--- contact --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-contact relative overflow-hidden radius mx-6' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class=" __wrapper relative" style="background-image:linear-gradient(rgba(0,46,255,0.6), rgba(0,46,255,0.6)), url('{{ $g_contact_1['image']['url'] }}'); background-size:cover; background-position:center;">
		<div class="__inside c-main relative py-60">
			<div class="relative grid grid-cols-1 lg:grid-cols-2 items-center gap-10 z-10">
				<div class="__content flex flex-col justify-between">
					<h2 data-gsap-element="header" class="text-white">{!! $g_contact_1['header'] !!}</h2>
					<p data-gsap-element="txt" class="text-white">{!! $g_contact_1['text'] !!}</p>
					<hr data-gsap-element="line" class="border-white mix-blend-overlay opacity-20 mt-6">
					<p data-gsap-element="txt" class="text-xl !font-semibold text-white/70 mt-6">Inne formy kontaktu</p>
					@if(!empty($g_contact_1['phone']))
					<a data-gsap-element="txt" class="__phone flex items-center !text-white mt-2" href="tel:{{ $g_contact_1['phone'] }}">{{ $g_contact_1['phone'] }}</a>
					@endif
					@if(!empty($g_contact_1['mail']))
					<a data-gsap-element="txt" class="__mail flex items-center !text-white mt-2" href="mailto:{{ $g_contact_1['mail'] }}">{{ $g_contact_1['mail'] }}</a>
					@endif

					<hr data-gsap-element="line" class="border-white mix-blend-overlay opacity-20 mt-6">
					<p data-gsap-element="txt" class="text-xl !font-semibold text-white/70 mt-6">Gdzie jesteśmy</p>
					<p data-gsap-element="txt" class="__address text-white mt-2">{!! $g_contact_1['address'] !!}</p>
					<x-button
						href="#lokalizacje"
						variant="white"
						class="mt-6"
						data-gsap-element="btn">
						Sprawdź jak dojechać
					</x-button>
				</div>

				<div data-gsap-element="form" class="bg-white radius p-10">
					<h4 class="!text-dark mb-4">{!! $g_contact_2['title'] !!}</h4>
					{!! do_shortcode($g_contact_2['shortcode']) !!}
				</div>
			</div>
		</div>
	</div>

</section>