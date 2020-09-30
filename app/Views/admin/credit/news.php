<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>新闻资讯</h1>
        <!--        --><?php //echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <br>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!--数据列表顶部-->
                    <div class="box-header">
                        <div>
                            <a title="添加" data-toggle="tooltip" class="btn btn-primary btn-sm "  href="/admin/credit/addNews">
                                <i class="fa fa-plus"></i> 添加
                            </a>
                            <a class="btn btn-success btn-sm ReloadButton" data-toggle="tooltip" title="刷新" data-id="checked" data-url="/admin/credit/news">
                                <i class="fa fa-refresh"></i> 刷新
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered datatable" width="100%">
                            <thead>
                            <tr>
                                <th>
                                    <input id="dataCheckAll" type="checkbox" onclick="checkAll(this)" class="checkbox" placeholder="全选/取消">
                                </th>
                                <th>ID</th>
                                <th>封面</th>
                                <th>内容</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data['lists'] as $key=>$value):?>
                                <tr>
                                    <td>
                                        <input type="checkbox" onclick="checkThis(this)" name="data-checkbox"
                                               data-id="<?php echo $value['id']?>" class="checkbox data-list-check" value="<?php echo $value['id']?>"
                                               placeholder="选择/取消">
                                    </td>
                                    <td><?php echo $value['id']?></td>
                                    <td>
                                        <img src="<?php echo $value["c_image"];?>" style="max-width: 50px;height: auto" class="showImg layui-upload-img"  alt="">
                                    </td>
                                    <td>
                                        <h3>标题：<?php echo $value['title'];?></h3>
                                        <br>
                                        <br>
                                        简介：<?php echo $value['desc']?>
                                    </td>
                                    <td>
                                        <?php echo date("Y-m-d H:i:s",$value['created_at'])?>
                                    </td>
                                    <td class="td-do">
                                        <a href="/admin/credit/editNews?id=<?php echo $value['id']?>" class="btn btn-primary btn-xs editUser" title="编辑新闻" data-toggle="tooltip">
                                            编辑新闻
                                        </a>

                                        <a class="btn btn-danger btn-xs deleteNews" title="删除新闻" data-id="<?php echo $value['id']?>" data-toggle="tooltip">
                                            删除新闻
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- 数据列表底部 -->
                    <div class="box-footer">
                        <?php echo $data["pager"]->links()?>
                        <label class="control-label pull-right" style="margin-right: 10px; font-weight: 100;">
                            <small>共<?php echo $data['count'];?>条记录</small>&nbsp;
                            <small>每页显示</small>
                            <select class="input-sm" onchange="changePerPage(this)">
                                <option value="10" <?php if($data['per_page'] == 10) echo "selected"?> >10</option>
                                <option value="20" <?php if($data['per_page'] == 20) echo "selected"?>>20</option>
                                <option value="30" <?php if($data['per_page'] == 30) echo "selected"?>>30</option>
                                <option value="50" <?php if($data['per_page'] == 50) echo "selected"?>>50</option>
                                <option value="100" <?php if($data['per_page'] == 100) echo "selected"?>>100</option>
                            </select>
                            &nbsp;
                            <small>条记录</small>
                        </label>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?php echo $this->include("admin/public/footer")?>

<script>
    //var keywords = "<?php //echo $data['keyword']?>//"
    //var status = "<?php //echo $data['status']?>//"
    //改变每页数量
    function changePerPage(obj) {
        var per_page = obj.value;
        window.location.href = "/admin/credit/news?per_page="+per_page
    }
</script>
<script>
    $(document).on("click",".showImg",function () {

        var src = $(this).attr("src")
        console.log(src)

        var imgHtml = "<img src='" + src + "' width='800px' />";
        //弹出层

        //页面层-图片

        layer.open({
            type: 1,
            title: false,
            closeBtn: 1,
            area: ['800px','auto'],
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: imgHtml
        });
    })

    $(document).on("click",".deleteNews",function (e) {
        var id = $(this).attr("data-id")
        layer.confirm("确定要删除新闻？", {title: "提示", closeBtn: 1, icon: 3}, function () {
            $.ajax({
                url:"/admin/credit/deleteNews",
                type:"POST",
                data:{id:id},
                dataType:"JSON",
                success:function(data){

                    if(data.status){
                        showMessage("success","操作成功","成功");

                        GoUrl("/admin/credit/news",1);
                    }else{
                        showMessage("error",data.message,"失败");

                        return false;
                    }

                },error:function(e){
                    showMessage("error", "操作失败","失败");
                    return false;
                }
            })

            layer.close(layer.index);
        });
    })
</script>
