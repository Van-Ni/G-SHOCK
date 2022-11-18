@if (!empty($child_cat))
    <ul class="sub-menu">
        @foreach ($child_cat as $child)
            <li>
                <a href="{{ route('childCat', ['parent_cat' => $parent->slug, 'child_cat' => $child->slug]) }}">
                    {{ $child->cat_name }}
                </a>
                @if (!empty($child->childCat))
                    @include('component.child_menu', ['child_cat' => $child->childCat])
                @endif
            </li>
        @endforeach
    </ul>
@endif
