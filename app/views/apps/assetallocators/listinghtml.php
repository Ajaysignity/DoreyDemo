<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="uk-grid-collapse" uk-height-viewport="expand: true">
    <div class="uk-container" style="padding: 3%;">
        <div class="uk-width">
            <h2>Client Asset Allocations</h2>
        </div>
        <div class="uk-overflow-container">
            <table class="uk-table uk-table-hover uk-table-divider uk-table-small assetallocatorTableData">
                <thead>
                    <tr>
                        <th width="65%">Name</th>
                        <th width="20%">Date modified</th>
                        <th width="15%" class="uk-text-right">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($lists) ):?>
                    <?php foreach( $lists as $list ):?>
                    <tr>
                        <td><a href="javascript:void(0);"
                                onClick="viewclientinformation('<?php echo encryptKey($list->iduserallocator);?>')"><span
                                    uk-icon="file-text"></span> <?php echo $list->ClientName;?></a> <i uk-icon="refresh"
                                class="processingspinner<?php echo encryptKey($list->iduserallocator);?> uk-spinner uk-margin-left"
                                hidden></i></td>
                        <td><?php echo ($list->modifieddate); ?></td>
                        <td class="uk-text-right"><a href="" uk-icon="pencil"></a>
                            <div uk-dropdown="mode: click">
                                <ul class="uk-nav uk-dropdown-nav">
                                    <li><a href="javascript:void();"
                                            onclick="common_view_modal('assetallocator/renameassetcollator?type=<?php echo encryptKey('rename');?>&iduserallocator=<?php echo encryptKey($list->iduserallocator);?>',this);">Rename
                                            solution</a></li>
                                    <li><a href="javascript:void();"
                                            onclick="common_view_modal('assetallocator/editassetallocator?iduserallocator=<?php echo encryptKey($list->iduserallocator);?>',this);">Adjust
                                            settings</a></li>
                                    <li><a href="javascript:void();"
                                            onclick="common_view_modal('assetallocator/renameassetcollator?type=<?php echo encryptKey('duplicate');?>&iduserallocator=<?php echo encryptKey($list->iduserallocator);?>',this);">Duplicate
                                            solution</a></li>
                                </ul>
                            </div>
                            <a href="javascript:void();"
                                onclick="common_view_modal('assetallocator/confirmdeteleassetcollator?type=<?php echo encryptKey('duplicate');?>&iduserallocator=<?php echo encryptKey($list->iduserallocator);?>',this);"
                                uk-icon="icon: trash"></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>