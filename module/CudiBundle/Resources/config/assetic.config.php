<?php
/**
 * Litus is a project by a group of students from the KU Leuven. The goal is to create
 * various applications to support the IT needs of student unions.
 *
 * @author Niels Avonds <niels.avonds@litus.cc>
 * @author Karsten Daemen <karsten.daemen@litus.cc>
 * @author Koen Certyn <koen.certyn@litus.cc>
 * @author Bram Gotink <bram.gotink@litus.cc>
 * @author Dario Incalza <dario.incalza@litus.cc>
 * @author Pieter Maene <pieter.maene@litus.cc>
 * @author Kristof Mariën <kristof.marien@litus.cc>
 * @author Lars Vierbergen <lars.vierbergen@litus.cc>
 * @author Daan Wendelen <daan.wendelen@litus.cc>
 *
 * @license http://litus.cc/LICENSE
 */

return array(
    'controllers'  => array(
        'cudi_install' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
        ),
        'cudi_admin_article' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_remote_typeahead',
        ),
        'cudi_admin_article_subject' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_remote_typeahead',
        ),
        'cudi_admin_article_comment' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_article_file' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@common_jquery_form',
            '@common_form_upload_progress',
            '@common_download_file',
            '@common_permanent_modal',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_article' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_download_file',
        ),
        'cudi_admin_sales_article_sale' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_article_discount' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_article_discount_template' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_article_barcode' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_article_restriction' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_booking' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_remote_typeahead',
            '@common_jquery_form',
        ),
        'cudi_admin_sales_session' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_session_restriction' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_session_openinghour' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_tab',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_jqueryui',
            '@common_jqueryui_datepicker',
            '@common_jqueryui_css',
            '@common_jqueryui_datepicker_css',
        ),
        'cudi_admin_sales_financial' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@common_jqueryui',
            '@common_jqueryui_datepicker',
            '@common_jqueryui_css',
            '@common_jqueryui_datepicker_css',
            '@common_download_file',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_financial_sold' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_financial_returned' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_financial_ordered' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_sales_financial_delivered' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_supplier' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_supplier_user' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_stock' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_download_file',
        ),
        'cudi_admin_stock_period' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_download_file',
        ),
        'cudi_admin_stock_order' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@common_download_file',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_remote_typeahead',
        ),
        'cudi_admin_stock_delivery' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_remote_typeahead',
            '@common_download_file',
        ),
        'cudi_admin_stock_retour' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_remote_typeahead',
            '@common_download_file',
        ),
        'cudi_admin_prof_action' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@common_download_file',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
        ),
        'cudi_admin_special_action' => array(
            '@common_jquery',
            '@admin_css',
            '@admin_js',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@common_remote_typeahead',
        ),
        'cudi_sale_sale' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@sale_js',
            '@sale_css',
            '@common_remote_typeahead',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@bootstrap_js_button',
            '@bootstrap_js_alert',
            '@common_permanent_modal',
            '@common_socket',
        ),
        'cudi_sale_queue' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@sale_css',
            '@queue_js',
            '@bootstrap_js_alert',
            '@common_socket',
        ),
        'cudi_sale_auth' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@sale_css',
            '@queue_js',
        ),
        'cudi_supplier_index' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@supplier_css',
        ),
        'cudi_supplier_article' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@supplier_css',
        ),
        'cudi_prof_index' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@prof_css',
        ),
        'cudi_prof_subject' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@prof_css',
        ),
        'cudi_prof_article' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@bootstrap_js_tooltip',
            '@bootstrap_js_popover',
            '@common_remote_typeahead',
            '@prof_css',
        ),
        'cudi_prof_article_mapping' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@common_remote_typeahead',
            '@prof_css',
        ),
        'cudi_prof_file' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@common_download_file',
            '@common_permanent_modal',
            '@common_jquery_form',
            '@common_form_upload_progress',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@prof_css',
        ),
        'cudi_prof_article_comment' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@prof_css',
        ),
        'cudi_prof_subject_comment' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@bootstrap_js_transition',
            '@bootstrap_js_modal',
            '@prof_css',
        ),
        'cudi_prof_prof' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@common_remote_typeahead',
            '@prof_css',
        ),
        'cudi_prof_help' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_alert',
            '@bootstrap_js_affix',
            '@prof_css',
        ),
        'cudi_booking' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@site_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_tooltip',
            '@bootstrap_js_popover',
            '@bootstrap_js_modal',
            '@bootstrap_js_transition',
            '@bootstrap_js_carousel',
            '@bootstrap_js_collapse',
            '@bootstrap_js_alert',
            '@booking_css',
        ),
        'cudi_opening_hour' => array(
            '@common_jquery',
            '@bootstrap_css',
            '@site_css',
            '@bootstrap_js_dropdown',
            '@bootstrap_js_transition',
            '@bootstrap_js_carousel',
            '@bootstrap_js_tooltip',
            '@bootstrap_js_popover',
            '@bootstrap_js_collapse',
            '@bootstrap_js_alert',
            '@opening_hour_css',
            '@opening_hour_js',
        ),
    ),

    'collections' => array(
        'sale_css' => array(
            'assets' => array(
                'sale/less/base.less',
            ),
            'filters' => array('less'),
            'options' => array(
                'output' => 'sale_css.css',
            ),
        ),
        'supplier_css' => array(
            'assets' => array(
                'supplier/less/base.less',
            ),
            'filters' => array('less'),
            'options' => array(
                'output' => 'supplier_css.css',
            ),
        ),
        'queue_js' => array(
            'assets' => array(
                'queue/js/*.js',
            ),
            'filters' => array('js'),
        ),
        'sale_js' => array(
            'assets' => array(
                'sale/js/*.js',
            ),
            'filters' => array('js'),
        ),
        'prof_css' => array(
            'assets' => array(
                'prof/less/base.less',
            ),
            'filters' => array('less'),
            'options' => array(
                'output' => 'prof_css.css',
            ),
        ),
        'booking_css' => array(
            'assets' => array(
                'booking/less/base.less',
            ),
            'filters' => array('less'),
            'options' => array(
                'output' => 'booking_css.css',
            ),
        ),
        'opening_hour_css' => array(
            'assets' => array(
                'opening-hour/less/schedule.less',
            ),
            'filters' => array('less'),
            'options' => array(
                'output' => 'opening_hour_css.css',
            ),
        ),
        'opening_hour_js' => array(
            'assets' => array(
                'opening-hour/js/*.js',
            ),
            'filters' => array('js'),
        ),
    ),
);