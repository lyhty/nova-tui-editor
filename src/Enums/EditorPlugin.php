<?php

namespace Lyhty\NovaTuiEditor\Enums;

enum EditorPlugin: string
{
    case CHART = 'chart';
    case CODE_SYNTAX_HIGHLIGHT = 'codeSyntaxHighlight';
    case COLOR_SYNTAX = 'colorSyntax';
    case TABLE_MERGED_CELL = 'tableMergedCell';
    case UML = 'uml';
}