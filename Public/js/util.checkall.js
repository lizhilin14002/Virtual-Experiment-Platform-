//当全选按纽(.all)点击时进行 全选/取消全选 操作
$('.all').on('click', function (e) {
    //当全选按钮（定位.all）被点击时，获取该多选框的选中属性
    $this = this;
    //在上一层结构（table标签）定位所有的input标签的（checked）属性，并将此选中状态与全选按钮的对应状态进行绑定
    $.each($(this).parents('table').find('input'), function (i, item) {
        $(item).prop('checked', $this.checked);
    });
});
//当批量删除按钮（#deleteA）点击时判断是否存在选中项
//有：提交；没有：提示，不进行提交
$('#deleteA').click(function () {
    if ($(':checked').size() > 0) {
        $("#list").submit();
    } else {
        alert('没有选择！');
    }
});