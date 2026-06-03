<!-- accordion -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-accordion relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="c-main">
		<div class="__wrapper">
			<div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-20 my-10">
				<div class="order1">
					@if (!empty($g_whyus['image']))
					<img data-gsap-element="img" class="__img object-cover order1 h-full aspect-square rounded-full" src="{{ $g_whyus['image']['url'] }}" alt="{{ $g_whyus['image']['alt'] ?? '' }}">
					@endif
				</div>
				<div class="__content order2 py-30">
					<h2 data-gsap-element="header" class="text-white m-header">{{ $g_whyus['title'] }}</h2>
					<div data-gsap-element="txt" class="text-white !text-base">{!! $g_whyus['text'] !!}</div>
					@if (!empty($g_whyus['button']))
					<a class="main-btn m-btn" href="{{ $g_whyus['button']['url'] }}">{{ $g_whyus['button']['title'] }}</a>
					@endif
					<div data-gsap-element="accordion" class="accordion-wrapper grid mt-6">
						@foreach ($r_whyus as $item)
						<div class="accordion rounded-2xl bg-white h-max">
							<input class="acc-check" type="radio" name="accordion-radio" id="check{{ $loop->index }}" {{ $loop->first ? 'checked' : '' }}>
							<label class="accordion-label flex items-center justify-between font-semibold text-md md:text-h5 gap-4" for="check{{ $loop->index }}">
								<div class="flex items-center gap-4">
									<img class="w-6 h-6" src="{{ $item['icon']['url'] }}" alt="{{ $item['icon']['alt'] ?? '' }}">
									<div class="!font-semibold">{{ $item['title'] }}</div>
								</div>
								<x-icon.plus class="__icon-plus text-primary w-5 h-5" />
								<x-icon.minus class="__icon-minus text-primary w-5 h-5 hidden" />
							</label>
							<div class="accordion-content">
								{!! $item['text'] !!}
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</section>