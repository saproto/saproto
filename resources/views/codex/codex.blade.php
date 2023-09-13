
    <page>

        <page_footer>
            <div style="font-size: 8pt;width: 100%; text-align: right">
                [[page_cu]]
            </div>
        </page_footer>

        @if($index==0)
            <div style="font-size: 8pt; font-weight:bold">
                {{$category->type}}
            </div>
        @endif



        <div style="font-size: 8pt;">
        {!! Markdown::convert($text->text) !!}
        </div>

    </page>


{{--@foreach($songCategories as $category)--}}
{{--    <page>--}}
{{--        <page_footer>--}}
{{--            <div style="font-size: 8pt; width: 100%; text-align: right">--}}
{{--                [[page_cu]]--}}
{{--            </div>--}}
{{--        </page_footer>--}}

{{--        <bookmark title="{{$category->name}}" level='0' ></bookmark>--}}
{{--        <div style="font-size: 12pt;">--}}
{{--            {{$category->name}}--}}
{{--        </div>--}}
{{--        @foreach($category->songs as $song)--}}
{{--                @if($song->lyrics && $song->lyrics!="")--}}

{{--                <bookmark title="{{$song->title}}" level='1' ></bookmark>--}}



{{--                    <span style="font-size: 8pt;">--}}
{{--                        <span style="font-size: 8pt; font-weight:bold">--}}
{{--                            {{$song->title}}--}}
{{--                        </span>--}}
{{--                        {!! Markdown::convert($song->lyrics) !!}--}}
{{--                    </span>--}}
{{--                    <br><br>--}}
{{--                @endif--}}
{{--        @endforeach--}}
{{--    </page>--}}
{{--@endforeach--}}
