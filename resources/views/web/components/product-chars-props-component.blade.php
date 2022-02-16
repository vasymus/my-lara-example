<?php
/** @var \Domain\Products\Models\Product\Product $product */
?>

@if(!$product->characteristicsIsEmpty())
<table cellspacing="0" cellpadding="0" class="product-properties">
    @foreach($product->characteristics() as $charCategoryCharsDTO)
    <tbody>
        <tr>
            <th colspan="2">
                <div class="product-properties__title">{{$charCategoryCharsDTO->name}}</div>
            </th>
        </tr>
        @foreach($charCategoryCharsDTO->chars as $charDTO)
            <tr>
                <td>{{$charDTO->name}}</td>
                <td>
                    {{$charDTO->html}}
                </td>
            </tr>
        @endforeach
    </tbody>
    @endforeach
</table>
@else
    <p style="text-align: center;">---</p>
@endif
