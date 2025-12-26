<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Filament\Resources\PostCategories\Schemas\PostCategoryForm;
use App\Models\Post;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\TextSize;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('slug')
                    ->label('ЧПУ')
                    ->helperText('генерируется всегда автоматически используя краткий заголовок')
                    ->copyable()
                    ->fontFamily(FontFamily::Mono)
                    ->size(TextSize::Medium)
                    ->columnSpanFull()
                    ->hiddenOn('create'),

                Select::make('post_category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->native(false)
                    ->searchable()
                    ->createOptionForm(PostCategoryForm::getComponents())
                    ->createOptionModalHeading('Добавить новую категорию')
                    ->required()
                    ->preload(),

                TextInput::make('short_title')
                    ->label('Краткий заголовок')
                    ->maxLength(255)
                    ->required(),

                TextInput::make('title')
                    ->label('Заголовок')
                    ->maxLength(255)
                    ->required(),

                Select::make('user_id')
                    ->label('Автор')
                    ->relationship('author', 'name')
                    ->searchable(['name', 'email'])
                    ->native(false)
                    ->required()
                    ->preload(),

                Textarea::make('excerpt')
                    ->label('Краткое описание')
                    ->required()
                    ->autosize(),

                Toggle::make('is_published')
                    ->label('Опубликован')
                    ->required()
                    ->inline(false)
                    ->default(false),

                FileUpload::make('image_path')
                    ->label('Изображение')
                    ->image()
                    ->imageEditor()
                    ->directory('posts')
                    ->disk('public')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->required()
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('Текст статьи')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'clearFormatting', 'link'],
                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'code', 'codeBlock', 'highlight'],
                        ['bulletList', 'orderedList'],
                        ['horizontalRule', 'details', 'lead', 'small'],
                        ['table', 'tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn', 'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow', 'tableMergeCells', 'tableSplitCell'],
                        ['attachFiles'],
                        ['undo', 'redo'],
                    ])
                    ->fileAttachmentsAcceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                    ->fileAttachmentsMaxSize(5120)
                    ->fileAttachmentsDirectory('posts-content')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('public')
                    ->maxLength(150000)
                    ->required(),
            ]);
    }
}
