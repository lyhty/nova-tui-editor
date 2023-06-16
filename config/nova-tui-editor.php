<?php

use Lyhty\NovaTuiEditor\Enums;

return [
    // If null, app()->getLocale() is used.
    'language' => null,

    'initialEditType' => Enums\EditorType::WYSIWYG,

    'previewStyle' => Enums\PreviewStyle::TAB,

    'height' => '500px',

    'useCommandShortcut' => true,

    'usageStatistics' => false,

    'hideModeSwitch' => false,

    'toolbarItems' => [
        [
            Enums\EditorToolbarItem::HEADING,
            Enums\EditorToolbarItem::BOLD,
            Enums\EditorToolbarItem::ITALIC,
            Enums\EditorToolbarItem::STRIKE,
        ],
        [
            Enums\EditorToolbarItem::HR,
            Enums\EditorToolbarItem::QUOTE,
        ],
        [
            Enums\EditorToolbarItem::UL,
            Enums\EditorToolbarItem::OL,
            Enums\EditorToolbarItem::TASK,
            Enums\EditorToolbarItem::INDENT,
            Enums\EditorToolbarItem::OUTDENT,
        ],
        [
            Enums\EditorToolbarItem::TABLE,
            Enums\EditorToolbarItem::IMAGE,
            Enums\EditorToolbarItem::LINK,
        ],
        [
            Enums\EditorToolbarItem::CODE,
            Enums\EditorToolbarItem::CODEBLOCK,
        ]
    ],

    'plugins' => [
        Enums\EditorPlugin::CHART,
        Enums\EditorPlugin::TABLE_MERGED_CELL,
        Enums\EditorPlugin::UML,
        Enums\EditorPlugin::COLOR_SYNTAX,
        Enums\EditorPlugin::CODE_SYNTAX_HIGHLIGHT,
    ],
];
