@php
$sectionClass = '';
$sectionClass .= $flip ? ' order-flip' : '';
$sectionClass .= $wide ? ' wide' : '';
$sectionClass .= $nomt ? ' !mt-0' : '';
$sectionClass .= $gap ? ' wider-gap' : '';
$sectionClass .= $lightbg ? ' section-light' : '';
$sectionClass .= $graybg ? ' section-gray' : '';
$sectionClass .= $whitebg ? ' section-white' : '';
$sectionClass .= $brandbg ? ' section-brand' : '';
@endphp

<!--- tabs --->

<section data-gsap-anim="section" @if($id) id="{{ $id }}" @endif class="b-tabs -smt {{ $sectionClass }} {{ $class }}">
	<div class="c-wide bg-white radius section-py">
		<div class="c-main">
			<div class="w-full md:w-1/2 m-auto text-center">
				<h2 data-gsap-element="header">{{ $g_tabs['title'] ?? '' }}</h2>
				@if(!empty($g_tabs['txt']))
				<p data-gsap-element="txt" class="mt-2 text-xl">{!! $g_tabs['txt'] !!}</p>
				@endif
			</div>

			@if (!empty($r_tabs) && is_array($r_tabs))
			@php $activeIndex = 0; @endphp

			<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start pt-14">

				{{-- LEWY PANEL: TABS --}}
				<div class="lg:col-span-3 h-full">
					<div data-gsap-element="tabs"
						class="flex flex-col h-full js-tabs-nav gap-4 lg:gap-0 overflow-x-scroll lg:overflow-x-visible px-5 lg:px-0"
						role="tablist" aria-orientation="vertical">
						@foreach ($r_tabs as $i => $tab)
						<button
							type="button"
							class="tab_btn w-full text-left px-10 py-6 rounded-xl transition {{ $i === $activeIndex ? 'active' : '' }}"
							data-tab-index="{{ $i }}"
							@if(!empty($tab['map_lat']) && !empty($tab['map_lng']))
							data-map-lat="{{ $tab['map_lat'] }}"
							data-map-lng="{{ $tab['map_lng'] }}"
							@endif
							role="tab"
							aria-selected="{{ $i === $activeIndex ? 'true' : 'false' }}">
							<div class="flex flex-col gap-1 w-full">
								<span class="text-lg !font-bold">{{ $tab['tab'] ?? 'Zakładka ' . ($i+1) }}</span>
								@if(!empty($tab['tab_desc']))
								<span class="text-base">{!! $tab['tab_desc'] !!}</span>
								@endif
								@if(!empty($tab['tab_extra']))
								<div class="flex items-center gap-2">
									<img src="/wp-content/uploads/2026/05/phone.svg" alt="Ikona telefonu" class="">
									<span class="">{{ $tab['tab_extra'] }}</span>
								</div>
								@endif
							</div>
						</button>
						@endforeach
					</div>
				</div>

				{{-- PRAWY PANEL: WSPÓLNA MAPA --}}
				<div data-gsap-element="content" class="lg:col-span-9">
					@if (!empty($locations) && is_array($locations))
					<div
						class="js-osm-shared radius overflow-hidden"
						style="height: 600px;"
						data-zoom="{{ $map_zoom ?: 12 }}"
						data-locations='@json($locations)'></div>
					@endif
				</div>

			</div>
			@endif
		</div>
	</div>

</section>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>