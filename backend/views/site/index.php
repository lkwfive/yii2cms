<div class="admin-default-index">
    <div class="box">
        <div class="box-header">
          <h3 class="box-title">系统信息</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>程序版本</td>
                        <td>v20220401</td>
                    </tr>
                    <tr>
                        <td>服务器系统</td>
                        <td><?= PHP_OS; ?></td>
                    </tr>
                    <tr>
                        <td>服务器架构</td>
                        <td><?= php_uname('m'); ?></td>
                    </tr>
                    <tr>
                        <td>服务器 PHP 版本</td>
                        <td><?= PHP_VERSION; ?></td>
                    </tr>
                    <tr>
                        <td>服务器 MySQL 版本</td>
                        <td><?= extension_loaded('pdo_mysql')?"PDO(√)":"PDO(×)"; ?></td>
                    </tr>
                    <tr>
                        <td>GD库支持</td>
                        <td>
                            <?php 
                                $tmp = function_exists('gd_info') ? gd_info() : array(); 
                                echo empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>上传限制</td>
                        <td><?= @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow'; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
      </div>
</div>
