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
                        {if isset($smarty.get.m)}
                            <div class="alert alert-info">{$smarty.get.m}</div>
                        {/if}
                        <div id="player"></div>
                        <div class="row">
                            <div class="col-md-12 mt-5">
                                <h4>Add new Sermon</h4>
                                <form action="/wp-admin/add-sermon" method="post" enctype="multipart/form-data">
                                    <label>Video Title</label>
                                    <div class="input-group input-danger-o">
                                        <input type="text" class="form-control" name="title" placeholder="Title"/>
                                    </div>
                                    <label>Video / Stream url</label>
                                    <div class="input-group input-success-o">
                                        <input type="text" class="form-control" name="url" placeholder="Url / Link to video or stream"/>
                                    </div>
                                    <label>Video / Sermon description</label>
                                    <div class="form-group input-info">
                                        <textarea name="description" class="form-control" placeholder="Description"></textarea>

                                    </div>
                                    <div class="input-group mb-3 mt-3">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary col-12 mt-2">ADD</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        {foreach $sermons as $item}
                            <div class="media mb-2 p-3 border-bottom">
                                <img src="/media/{$item.image}" class="float-left" style="width:100px;"/>
                                <div class="media-body pl-2">
                                    <a href="/wp-admin/sermons?watch={$item.url}">
                                        <h4>{$item.video_title}</h4>
                                        <small>{$item.video_description}<br/><span class="text-muted">{$item.date_added}</span></small>
                                    </a>
                                    <br/>
                                    <small>
                                        <a href="/wp-admin/del/{$item.id}?i=del" class="text-danger"><i class="fa fa-times"></i></a>
                                        <a href="/wp-admin/del/{$item.id}?i=hide" class="text-danger"><i class="fa fa-eye" title="Toggle show hide"></i></a>
                                        | {if $item.status == 0} Unpublished{else}Published{/if}
                                    </small>
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
        let video = "{if isset($sermon)} {$sermon.0.video_url}{else}{$sermons.0.video_url}{/if}";
        let title = "{if isset($sermon)} {$sermon.0.video_title}{else}{$sermons.0.video_title}{/if}";
        {literal}
        let player = new Playerjs({id:"player", title:title, player:2, file:video});
        {/literal}
    </Script>
{/block}