<!--- tiles -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-tiles relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-20">

			<div class="__tiles order1 relative lg:sticky top-0 lg:top-20 h-max">
				@if (!empty($g_tiles['icon']['url']))
				<img data-gsap-element="icon" class="bg-white rounded-full p-4 mb-6" src="{{ $g_tiles['icon']['url'] }}" alt="{{ $g_tiles['icon']['alt'] ?? '' }}" />
				@endif
				<h2 data-gsap-element="header" class="text-white">{{ $g_tiles['header'] }}</h2>

				<div data-gsap-element="txt" class="__txt text-white mt-4">
					{!! $g_tiles['text'] !!}
				</div>

				<div class="inline-buttons m-btn">
					@if (!empty($g_tiles['button1']))
					<x-button
						:href="$g_tiles['button1']['url']"
						variant="white"
						class=""
						data-gsap-element="btn">
						{{ $g_tiles['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_tiles['button2']))
					<x-button
						:href="$g_tiles['button2']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_tiles['button2']['title'] }}
					</x-button>
					@endif
				</div>
			</div>

			<div class="__row order2">

				<div class="grid gap-10">
					@foreach ($r_tiles as $item)
					<div data-gsap-element="card" class="__card relative border border-white/50 radius p-10">
						@if (!empty($item['image']['url']))
						<img class="bg-white rounded-full p-4 mb-6" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
						@endif
						@if (!empty($item['title']))
						<p class="text-h5 text-white">{{ $item['title'] }}</p>
						@endif
						@if (!empty($item['text']))
						<p class="text-white">{{ $item['text'] }}</p>
						@endif
					</div>
					@endforeach
				</div>

			</div>

		</div>
	</div>

</section>