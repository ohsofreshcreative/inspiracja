<!-- accordion -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-accordion relative bg-light -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="c-main">
		<div class="__wrapper">
			<div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-20 my-10 py-20 lg:py-0">
				<div>
					@if (!empty($g_accordion['image']))
					<img data-gsap-element="img" class="__img relative lg:absolute top-0 left-0 w-full lg:w-11/24 object-cover order1 h-full  rounded-4xl lg:rounded-r-full" src="{{ $g_accordion['image']['url'] }}" alt="{{ $g_accordion['image']['alt'] ?? '' }}">
					@endif
				</div>
				<div class="__content order2 py-0 lg:py-30">
					<h2 data-gsap-element="header" class="m-header">{{ $g_accordion['title'] }}</h2>
					<div data-gsap-element="txt" class="!text-base">{!! $g_accordion['text'] !!}</div>
					@if (!empty($g_accordion['button']))
					<a class="main-btn m-btn" href="{{ $g_accordion['button']['url'] }}">{{ $g_accordion['button']['title'] }}</a>
					@endif
					<div data-gsap-element="accordion" class="accordion-wrapper grid mt-6">
						@foreach ($r_accordion as $item)
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