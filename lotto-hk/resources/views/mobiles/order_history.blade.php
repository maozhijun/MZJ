<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//cdn.bootcss.com/jquery-mobile/1.4.5/jquery.mobile.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/jquery-mobile/1.4.5/jquery.mobile.js"></script>
    <style>
        .ball {
            float: left;
            margin: .2em;
            line-height: 1.6em;
            height: 1.6em;
            width: 1.6em;
            display: inline-block;
            text-align: center;
            border-radius: 50%;
            background: #c0c0c0;
            color: #fff;
            text-shadow: none;
        }

        .ball.hit {
            background: #FB223D;
            color: #fff;
        }

        .fee {
            width: 30%;
            font-size: .8em;
            position: relative;
            display: inline-block;
        }

        .odd {
            width: 30%;
            font-size: .8em;
            line-height: 1.6em;
            height: 1.6em;
            text-align: center;
            display: inline-block;
        }

        .bonus {
            width: 40%;
            font-size: .8em;
            line-height: 1.6em;
            height: 1.6em;
            text-align: right;
            display: inline-block;
        }

        .date {
            font-size: .8em;
            position: relative;
            line-height: 1.6em;
            height: 1.6em;
            width: 50%;
            text-align: right;
            display: inline-block;
        }

        .status {
            font-size: .8em;
            position: relative;
            width: 50%;
            line-height: 1.6em;
            height: 1.6em;
            display: inline-block;
        }

        .money {
            color: #FB223D;
        }

        .money.clean,.money.un-hit {
            color: #9BA2AB;
            text-decoration: line-through;
        }

        .unknown {
            color: #9BA2AB;
        }

        .hit {
            color: #FB223D;
        }

        .un-hit {
            color: #1fc26b;
        }

        .clean {
            color: #9BA2AB;
        }
    </style>
</head>
<body>
<div data-role="page" id="main">
    <div data-role="header">
        <h1 class="title">已结算订单</h1>
        <a href="#" data-rel="back"
           class="ui-btn ui-btn-icon-notext ui-corner-all ui-icon-back ui-nodisc-icon ui-alt-icon ui-btn-left"></a>
        <a href="/mobiles/" data-ajax="false"
           class="ui-btn ui-btn-icon-notext ui-corner-all ui-icon-home ui-nodisc-icon ui-alt-icon ui-btn-right"></a>
    </div>
    <div role="main" class="ui-content">
        <div style="margin:-1em -.5em;">
            <ul data-role="listview" data-inset="true">
                @foreach($issues as $issue=>$orders)
                    <li data-role="list-divider">
                        第{{ $issue }}期 <span class="ui-li-count">{{ count($orders) }}</span>
                    </li>
                    @foreach($orders as $order)
                        <li>
                            <h3>{{ $order->game->name }}</h3>
                            <div class="items">
                                @foreach(explode('|',$order->items) as $item)
                                    <span class="ball {{ str_contains($order->hit_item, $item)?'hit':'' }}">{{ $item }}</span>
                                @endforeach
                            </div>
                            <div class="items" style="clear: left">
                                <span class="fee">
                                    本金：<strong class="money">{{ '￥'.number_format($order->total_fee,2,'.','') }}</strong>
                                </span>
                                <span class="odd">
                                    赔率：<strong class="money">{{ '@'.number_format($order->odd,2,'.','') }}</strong>
                                </span>
                                <span class="bonus">
                                    返还：<strong class="money {{ $order->statusCSS() }}">{{ '￥'.number_format($order->bonus,2,'.','') }}</strong>
                                </span>
                            </div>
                            <div class="items">
                                <span class="status">
                                    状态：<strong class="{{ $order->statusCSS() }}">{{ $order->statusCN() }}</strong>
                                </span>
                                <span class="date">
                                    时间：<strong class="unknown">{{ substr($order->created_at,0,16) }}</strong>
                                </span>
                            </div>
                        </li>
                    @endforeach
                @endforeach
            </ul>
            <div data-role="controlgroup" data-type="horizontal" data-mini="true">
                <a href="{{ $page_orders->url(1) }}"
                   class="ui-btn ui-corner-all {{ $page_orders->currentPage()==1?'ui-state-disabled':'' }}"> 首页 </a>
                <a href="{{ $page_orders->previousPageUrl() }}"
                   class="ui-btn ui-corner-all {{ $page_orders->currentPage()==1?'ui-state-disabled':'' }}"> 上一页 </a>
                <a href="#" class="ui-btn ui-corner-all">{{ $page_orders->currentPage() }}</a>
                <a href="{{ $page_orders->nextPageUrl() }}"
                   class="ui-btn ui-corner-all {{ $page_orders->currentPage()==$page_orders->lastPage()?'ui-state-disabled':'' }}">
                    下一页 </a>
                <a href="{{ $page_orders->url($page_orders->lastPage()) }}"
                   class="ui-btn ui-corner-all {{ $page_orders->currentPage()==$page_orders->lastPage()?'ui-state-disabled':'' }}">
                    尾页 </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>