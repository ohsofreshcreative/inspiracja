<!--- wysiwyg -->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-wysiwyg relative' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main relative pt-20 md:mt-0">
		@if (!empty($g_wysiwyg['header']))
		<p data-gsap-element="header" class="text-white text-h1">{{ $g_wysiwyg['header'] }}</p>
		@endif

		<div data-gsap-element="txt" class="__txt text-white mt-0 md:mt-40">
			{!! $g_wysiwyg['txt'] !!}
		</div>

		@if (!empty($g_wysiwyg['button']))
		<x-button
			:href="$g_wysiwyg['button']['url']"
			variant="primary"
			class="mt-6"
			data-gsap-element="btn">
			{{ $g_wysiwyg['button']['title'] }}
		</x-button>
		@endif
	</div>

</section>