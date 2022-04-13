{extends file="admin/index.tpl"}
{block name="body"}
    <div class="row">
        <div class="card col-md-10 mx-auto">
            <div class="card-header">
                <h4 class="card-title">VIDEO SERMONS</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div id="player"></div>
                    </div>
                    <div class="col-md-4">
                        {foreach $sermons as $item}
                            <div class="media mb-2 p-3 border-bottom">
                                <img src="{$item.image}" class="float-left" style="width:100px;"/>
                                <div class="media-body pl-2">
                                    <h4>{$item.video_title}</h4>
                                    <small>{$item.video_description}<br/><span class="text-muted">{$item.date_added}</span></small>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}
{block name="scripts"}
    <script src="https://rhapsodyofrealities.b-cdn.net/rin/assets/playerjs.js"></script>
    <Script>
        {literal}
        let player = new Playerjs({id:"player", title:"Video", player:2, file:""});
        {/literal}
    </Script>
{/block}