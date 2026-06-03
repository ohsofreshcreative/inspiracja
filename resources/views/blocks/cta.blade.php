<!--- cta -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-cta relative z-5 -smt overflow-hidden radius mx-6' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper py-42" style="background-image:linear-gradient(rgba(0,46,255,0.6), rgba(0,46,255,0.6)), url('{{ $g_cta['image']['url'] }}'); background-size:cover; background-position:center;">

		<div class="__inside c-main items-center gap-6">
			<div class="__content text-center w-full md:w-2/3 mx-auto">
				@if ($g_cta['header'])
				<p data-gsap-element="header" class="text-h2 text-white">{{ $g_cta['header'] }}</p>
				@endif
				@if ($g_cta['txt'])
				<div data-gsap-element="txt" class="text-white text-lg mt-1">{!! $g_cta['txt'] !!}</div>
				@endif
			</div>

			<div class="inline-buttons justify-center m-btn">
				@if (!empty($g_cta['button1']))
				<x-button
					:href="$g_cta['button1']['url']"
					variant="white"
					class=""
					data-gsap-element="btn">
					{{ $g_cta['button1']['title'] }}
				</x-button>
				@endif

				@if (!empty($g_cta['button2']))
				<x-button
					:href="$g_cta['button2']['url']"
					variant="secondary"
					class=""
					data-gsap-element="btn">
					{{ $g_cta['button2']['title'] }}
				</x-button>
				@endif
			</div>
		</div>

	</div>

</section>

<img class="max-w-[800px] relative z-10 -mt-32 mx-auto" src="/wp-content/uploads/2026/06/bottom-img.svg" />