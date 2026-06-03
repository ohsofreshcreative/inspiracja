<!--- content -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-content relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-20">
			@if (!empty($g_content['image']))
			<div data-gsap-element="img" class="__img h-full order1">
				<img class="rounded-full object-cover aspect-square" src="{{ $g_content['image']['url'] }}" alt="{{ $g_content['image']['alt'] ?? '' }}">
				@if (!empty($circle))
				<div class="__circle"></div>
				@endif
			</div>
			@endif

			<div class="__content order2">
				@if (!empty($g_content['icon']['url']))
				<img data-gsap-element="icon" class="bg-white rounded-full p-4 mb-6" src="{{ $g_content['icon']['url'] }}" alt="{{ $g_content['icon']['alt'] ?? '' }}" />
				@endif
				<h2 data-gsap-element="header" class="text-h4 text-white">{{ $g_content['header'] }}</h2>

				<div data-gsap-element="txt" class="__txt text-white mt-4">
					{!! $g_content['text'] !!}
				</div>

				<div class="inline-buttons m-btn">
					@if (!empty($g_content['button1']))
					<x-button
						:href="$g_content['button1']['url']"
						variant="white"
						class=""
						data-gsap-element="btn">
						{{ $g_content['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_content['button2']))
					<x-button
						:href="$g_content['button2']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_content['button2']['title'] }}
					</x-button>
					@endif
				</div>

			</div>

		</div>
	</div>

</section>