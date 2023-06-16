<?php

namespace Lyhty\NovaTuiEditor\Enums;

enum EditorToolbarItem: string
{
    case BOLD = 'bold';
    case CODE = 'code';
    case CODEBLOCK = 'codeblock';
    case HEADING = 'heading';
    case HR = 'hr';
    case IMAGE = 'image';
    case INDENT = 'indent';
    case ITALIC = 'italic';
    case LINK = 'link';
    case OL = 'ol';
    case OUTDENT = 'outdent';
    case QUOTE = 'quote';
    case SCROLL_SYNC = 'scrollSync';
    case STRIKE = 'strike';
    case TABLE = 'table';
    case TASK = 'task';
    case UL = 'ul';
}
