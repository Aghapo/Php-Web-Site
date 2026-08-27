<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc(lang('Email.reset_subject')) ?></title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f6f8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f4f6f8; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); }
        .header { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 35px 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .content { padding: 35px 30px; line-height: 1.6; }
        .greeting { font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 15px; }
        .btn-wrapper { text-align: center; margin: 30px 0; }
        .btn { display: inline-block; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3); }
        .warning-box { background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 6px; font-size: 14px; color: #92400e; margin: 20px 0; }
        .notice { font-size: 13px; color: #6b7280; margin-top: 25px; border-top: 1px solid #e5e7eb; padding-top: 15px; }
        .footer { background-color: #f9fafb; padding: 20px 30px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #f3f4f6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Başlık -->
            <div class="header">
                <h1><?= esc(lang('Email.app_name')) ?></h1>
            </div>

            <!-- İçerik -->
            <div class="content">
                <div class="greeting">
                    <?= lang('Email.greeting', ['name' => esc($name ?? 'Kullanıcı')]) ?>
                </div>

                <p><?= esc(lang('Email.reset_text')) ?></p>

                <!-- Şifre Sıfırlama Butonu -->
                <div class="btn-wrapper">
                    <a href="<?= esc($resetUrl) ?>" class="btn" target="_blank">
                        <?= esc(lang('Email.reset_btn')) ?>
                    </a>
                </div>

                <div class="warning-box">
                    <strong>⚠️ <?= esc(lang('Email.reset_warning')) ?></strong>
                </div>

                <div class="notice">
                    <p><strong>ℹ️</strong> <?= esc(lang('Email.reset_expire')) ?></p>
                    <p style="word-break: break-all; font-size: 12px; color: #9ca3af;">
                        <?= esc($resetUrl) ?>
                    </p>
                </div>
            </div>

            <!-- Alt Bilgi -->
            <div class="footer">
                <p><?= esc(lang('Email.footer_notice')) ?></p>
                <p>&copy; <?= date('Y') ?> <?= esc(lang('Email.app_name')) ?>. <?= esc(lang('Email.rights_reserved')) ?></p>
            </div>
        </div>
    </div>
</body>
</html>
