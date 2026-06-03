<!-- banner --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-banner relative overflow-hidden radius mx-6' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class=" __wrapper relative" style="background-image:linear-gradient(rgba(0,46,255,0.6), rgba(0,46,255,0.6)), url('{{ $g_banner['image']['url'] }}'); background-size:cover; background-position:center;">
		<div class="__inside c-main relative">
			<div class="__content py-40">

				<div class="text-center w-full md:w-2/3 mx-auto">
					<h1 data-gsap-element="header" class=" text-white">
						{!! $g_banner['header'] !!}
					</h1>
					<p data-gsap-element="txt" class="text-lg text-white mt-2">
						{!! $g_banner['text'] !!}
					</p>
					@if (!empty($g_banner['button1']) || !empty($g_banner['button2']))
					<div class="inline-buttons mx-auto m-btn justify-center">
						@if (!empty($g_banner['button1']))
						<x-button
							:href="$g_banner['button1']['url']"
							variant="secondary"
							class=""
							data-gsap-element="btn">
							{{ $g_banner['button1']['title'] }}
						</x-button>
						@endif

						@if (!empty($g_banner['button2']))
						<x-button
							:href="$g_banner['button2']['url']"
							variant="white"
							class=""
							data-gsap-element="btn">
							{{ $g_banner['button2']['title'] }}
						</x-button>
						@endif
					</div>
					@endif
				</div>
			</div>
		</div>

</section>