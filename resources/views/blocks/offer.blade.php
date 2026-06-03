<!--- offer -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-offer relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative z-10">
		<div class="__top w-full md:w-1/2 mx-auto">
			<h2 data-gsap-element="header" class="text-white text-center">{{ $g_offer['header'] }}</h2>
			<div data-gsap-element="txt" class="text-white text-center text-lg mt-4">
				{!! $g_offer['text'] !!}
			</div>
		</div>

		<div class="__col grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-20 mt-10">
			<div class="__row relative lg:sticky top-0 lg:top-20 h-max flex flex-col items-center">
				@if (!empty($g_offer['image']))
				<div data-gsap-element="img" class="__img h-full w-full order1">
					<img class="rounded-full img-md w-full object-cover" src="{{ $g_offer['image']['url'] }}" alt="{{ $g_offer['image']['alt'] ?? '' }}">
				</div>
				@endif
				<div data-gsap-element="txt" class="text-white text-center text-h4 mt-4">
					{!! $g_offer['title'] !!}
				</div>
				@if (!empty($g_offer['button']))
				<x-button
					:href="$g_offer['button']['url']"
					variant="white"
					class="m-btn"
					data-gsap-element="btn">
					{{ $g_offer['button']['title'] }}
				</x-button>
				@endif
			</div>

			<div class="__row order2">

				<div class="grid gap-30 mt-6">
					@foreach ($r_offer as $item)
					<div data-gsap-element="card" class="__card relative">
						@if (!empty($item['image']['url']))
						<img class="bg-white rounded-full p-4 mb-6" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
						@endif
						@if (!empty($item['title']))
						<p class="text-h5 text-white">{{ $item['title'] }}</p>
						@endif
						@if (!empty($item['text']))
						<p class="text-white">{{ $item['text'] }}</p>
						@endif

						@if (!empty($item['button']))
						<x-button
							:href="$item['button']['url']"
							variant="outline-white"
							class="m-btn"
							data-gsap-element="btn">
							{{ $item['button']['title'] }}
						</x-button>
						@endif
					</div>
					@endforeach
				</div>

			</div>

		</div>
	</div>

	<img class="absolute opacity-20 bottom-0" src="/wp-content/uploads/2026/06/wave.svg" />

</section>