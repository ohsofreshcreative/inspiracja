<!--- about -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-about relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative z-10">
		<div class="__col grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-20">
			@if (!empty($g_about['image']))
			<div data-gsap-element="img" class="__img h-full order1">
				<img class="rounded-full" src="{{ $g_about['image']['url'] }}" alt="{{ $g_about['image']['alt'] ?? '' }}">
			</div>
			@endif

			<div class="__about order2">
				<h1 data-gsap-element="header" class="text-white">{{ $g_about['header'] }}</h1>

				<div data-gsap-element="txt" class="__txt text-white mt-4">
					{!! $g_about['text'] !!}
				</div>

				<div class="inline-buttons m-btn">
					@if (!empty($g_about['button1']))
					<x-button
						:href="$g_about['button1']['url']"
						variant="primary"
						class=""
						data-gsap-element="btn">
						{{ $g_about['button1']['title'] }}
					</x-button>
					@endif

					@if (!empty($g_about['button2']))
					<x-button
						:href="$g_about['button2']['url']"
						variant="secondary"
						class=""
						data-gsap-element="btn">
						{{ $g_about['button2']['title'] }}
					</x-button>
					@endif
				</div>

			</div>

		</div>
	</div>
	<img class="absolute opacity-50 -top-11/12 z-0" src="/wp-content/uploads/2026/06/ring.svg" />
</section>