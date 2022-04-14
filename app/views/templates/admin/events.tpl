{extends file="admin/index.tpl"}
{block name="styles"}
    <link href="/assets/admin/vendor/summernote/summernote.css" rel="stylesheet">
{/block}
{block name="body"}
    <div class="row">
        <div class="card col-md-7">
            <div class="card-header">
                <h4 class="card-title">
                    Add event
                </h4>
            </div>
            <div class="card-body">
                {if isset($smarty.get.m)}
                    <div class="alert alert-info">{$smarty.get.m}</div>
                {/if}
                <form action="/wp-admin/add-event" method="post" enctype="multipart/form-data">
                    <label>TITLE</label>
                    <div class="input-group input-info">
                        <input type="text" required class="form-control" name="title" placeholder="Title"/>
                    </div>
                    <label>Event Body</label>
                    <textarea class="form-control summernote" required name="description"></textarea>
                    <labe>Dates</labe>
                    <div class="form-row">
                        <div class="form-group col-md-6 input-danger-o">
                            <label>Start Date</label>
                            <input type="date" required name="date[]" class="form-control" placeholder="Start date">
                        </div>
                        <div class="form-group col-md-6 input-danger-o">
                            <label>End Date</label>
                            <input type="date" required name="date[]" class="form-control" placeholder="End date">
                        </div>
                    </div>
                    <labe>Time</labe>
                    <div class="form-row">
                        <div class="form-group col-md-6 input-warning-o">
                            <label>Start time</label>
                            <input type="time" required name="time[]" class="form-control" placeholder="Start date">
                        </div>
                        <div class="form-group col-md-6 input-warning-o">
                            <label>End Date</label>
                            <input type="time" required name="time[]" class="form-control" placeholder="End time">
                        </div>
                    </div>
                    <label>
                        Photo
                    </label>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-12">Add Event
                    </button>
                </form>
            </div>
        </div>
        <div class="card col-md-5">
            <div class="card-header">
                <h4 class="card-title">
                    Events
                </h4>
            </div>
            <div class="card-body row">
                {foreach $events as $event}
                    <div class="col-md-12 mb-4 shadow p-0">
                        <img src="/media/{$event.image}" class="w-100"/>
                        <h4 class="pl-3 pr-3 pt-3 pb-3">{$event.title}</h4>
                        <div class="pl-3 pr-3">
                            <span class="btn btn-info"><span class="fa fa-calendar"></span> {$event.start_date} - {$event.end_date}</span>
                            <span class="btn btn-warning"><span class="fa fa-clock-o"></span> {$event.start_time} - {$event.end_time}</span>
                        </div>
                        <hr/>
                        <div class="pr-3 pb-3 pl-3">
                            <small>
                                <a href="/wp-admin/del-event/{$event.id}?i=del" class="text-danger"><i class="fa fa-times"></i></a>
                                <a href="/wp-admin/del-event/{$event.id}?i=hide" class="text-danger"><i class="fa fa-eye" title="Toggle show hide"></i></a>
                                | {if $event.status == 0} Unpublished{else}Published{/if}
                            </small>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
{/block}
{block name="scripts"}
    <!-- Summernote -->
    <script src="/assets/admin/vendor/summernote/js/summernote.min.js"></script>
    <!-- Summernote init -->
    <script src="/assets/admin/js/plugins-init/summernote-init.js"></script>
{/block}