<!-- Pagination -->
<nav class="ls-pagination">
    <ul>
        @if (!$paginator->onFirstPage())
            <li class="prev"><a href="{{ $paginator->previousPageUrl() }}" onclick="event.preventDefault();handlePagination(event, 'arrow')"><i class="fa fa-arrow-left"></i></a></li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a href="#" onclick="event.preventDefault()" class="current-page">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}" onclick="event.preventDefault();handlePagination(event)">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li class="next"><a href="{{ $paginator->nextPageUrl() }}" onclick="event.preventDefault();handlePagination(event, 'arrow')"><i class="fa fa-arrow-right"></i></a></li>
        @endif
    </ul>
</nav>
@section('script2')
    <script>
        function handlePagination(event, button) {
			let element = event.target;
			if (button === 'arrow') {
				element = event.target.parentElement;
			}
			const href = element.href;
			const pageUrl = href.split('?page=');
			const pageId = pageUrl[pageUrl.length - 1];
			handleSelectChange(event, 'page', pageId)
		}

        function handleSelectChange(event, type, pageId = null) {
			const { value } = event.target;
			const { origin, pathname, search } = window.location;

			const urlParams = new URLSearchParams(search); // For GET request
			if (type === 'category') {
				urlParams.append("category", value);
			} else if (type === 'filter') {
				urlParams.append("filter", value);
			} else if (type === 'limit') {
				urlParams.append("limit", value);
			} else if (type === 'title') {
				urlParams.append("title", value);
			} else if (type === 'location') {
				urlParams.append("location", value);
			} else if (type === 'name') {
				urlParams.append("name", value);
			} else if (type === 'status') {
				urlParams.append("status", value);
			} else if (type === 'page') {
				urlParams.append("page", pageId);
			} else {
				return;
			}

			if (type !== 'page') {
				urlParams.append("page", 1);
			}

			const urlQueryString = new URLSearchParams(Object.fromEntries(urlParams)).toString();
			window.location.href = `${origin}${pathname}?${urlQueryString}`;
		}
    </script>
@endsection