<div class="card borderless-card">
    <div class="card-block primary-breadcrumb">
        <div class="breadcrumb-header">
            <h5><?=$title?></h5>
            <span><?=$subtitle?></span>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb">
                <?php for ($i=0; $i < count($breadcrumb); $i++) { ?>
                    <?php if ($breadcrumb[$i]['href']): ?>
                    <li class="breadcrumb-item">
                        <a href="<?=$breadcrumb[$i]['tujuan']?>"><i class="fa <?=$breadcrumb[$i]['icon']?>"></i> </a>
                    </li>
                    <?php else: ?>
                    <li class="breadcrumb-item"><a href="javascript:void(0)"><?=$breadcrumb[$i]['title']?></a></li>
                    <?php endif ?>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>