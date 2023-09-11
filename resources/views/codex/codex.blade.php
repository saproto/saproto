<style>
    ol, p{
        width:80%;
    }

    th{
        font-weight: bold;
        text-align: center;
        padding: 0;
    }
    td, tr, table{
        padding: 0;
    }
</style>
@foreach($textCategories as $category)
    <page style="font">
        <page_footer>
            <div style="font-size: 8pt;width: 100%; text-align: right">
                [[page_cu]]
            </div>
        </page_footer>

        <bookmark title="{{$category->type}}" level='0' ></bookmark>
        <div style="font-size: 8pt; font-weight:bold">
            {{$category->type}}
        </div>
        @foreach($category->texts as $text)
                @if($text->text&&$text->text!="")
                        <bookmark title="{{$text->name}}" level='1' ></bookmark>

                        <div style="font-size: 8pt;">
                        {!! Markdown::convert($text->text) !!}
                        </div>
                @endif
        @endforeach
    </page>
@endforeach

@foreach($songCategories as $category)
    <page>
        <page_footer>
            <div style="font-size: 8pt; width: 100%; text-align: right">
                [[page_cu]]
            </div>
        </page_footer>

        <bookmark title="{{$category->name}}" level='0' ></bookmark>
        <div style="font-size: 12pt;">
            {{$category->name}}
        </div>
        @foreach($category->songs as $song)
                @if($song->lyrics && $song->lyrics!="")

                <bookmark title="{{$song->title}}" level='1' ></bookmark>



                    <span style="font-size: 8pt;">
                        <span style="font-size: 8pt; font-weight:bold">
                            {{$song->title}}
                        </span>
                        {!! Markdown::convert($song->lyrics) !!}
                    </span>
                    <br><br>
                @endif
        @endforeach
    </page>
@endforeach
