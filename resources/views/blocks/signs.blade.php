<!--- signs --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-signs relative border-t border-b border-primary-100/30 -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative z-10 py-8">
		@if (!empty($r_signs))
		<div data-gsap-element="card" class="swiper signs-marquee">
			<div class="swiper-wrapper">
				@foreach ($r_signs as $item)
					@if (!empty($item['header']))
					<div class="swiper-slide">
						<div class="__item text-primary-100/30">{{ $item['header'] }}</div>
					</div>
					@endif
				@endforeach
			</div>
		</div>
		@endif

	</div>

</section>