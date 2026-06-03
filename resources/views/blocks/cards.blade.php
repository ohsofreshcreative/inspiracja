<!--- cards --->

<section
	data-gsap-anim="section"
	@if(!empty($section_id)) id="{{ $section_id }}" @endif
	@class([ 'b-cards relative -smt' ,
	$sectionClass=> filled($sectionClass),
	$section_class => filled($section_class),
	$background => filled($background) && $background !== 'none',
	])>

	<div class="__wrapper c-main">
		<div class="__top w-full md:w-1/2 lg:w-1/3">
			<h2 data-gsap-element="header" class="m-header text-white">{{ strip_tags($g_cards['header']) }}</h2>
			<p data-gsap-element="text" class="text-white">{{ $g_cards['text'] }}</p>
		</div>

		<div class="text-white grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
			@foreach ($r_cards as $item)
			<div data-gsap-element="card" class="__card relative border border-white radius p-8">
				@if (!empty($item['image']['url']))
				<img  class="bg-white rounded-full p-4 mb-6" src="{{ $item['image']['url'] }}" alt="{{ $item['image']['alt'] ?? '' }}" />
				@endif
				@if (!empty($item['title']))
				<p class="text-h5">{{ $item['title'] }}</p>
				@endif
				@if (!empty($item['text']))
				<p>{{ $item['text'] }}</p>
				@endif
			</div>
			@endforeach
		</div>

	</div>

</section>