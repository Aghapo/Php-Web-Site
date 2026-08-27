<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc(lang('Email.reset_success_subject')) ?></title>
    <style>
        body { margin: 0; padding: 0; background-color: #f4f6f8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f4f6f8; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); }
        .header { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); padding: 35px 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .content { padding: 35px 30px; line-height: 1.6; }
        .greeting { font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 15px; }
        .btn-wrapper { text-align: center; margin: 30px 0; }
        .btn { display: inline-block; background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); }
        .warning-box { background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 15px; border-radius: 6px; font-size: 14px; color: #991b1b; margin: 20px 0; }
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

                <h2 style="font-size: 20px; color: #0284c7; margin-bottom: 15px;">
                    <?= esc(lang('Email.reset_success_title')) ?>
                </h2>

                <p><?= esc(lang('Email.reset_success_text')) ?></p>

                <!-- Giriş Yap Butonu -->
                <div class="btn-wrapper">
                    <a href="<?= esc($loginUrl) ?>" class="btn" target="_blank">
                        <?= esc(lang('Email.reset_success_btn')) ?>
                    </a>
                </div>

                <div class="warning-box">
                    <strong>🛡️ <?= esc(lang('Email.reset_success_warning')) ?></strong>
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
