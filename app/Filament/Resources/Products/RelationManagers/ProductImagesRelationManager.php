<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\ProductImage;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Изображения';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('path')
                    ->label('Изображение')
                    ->disk('public')
                    ->square(),

                TextColumn::make('alt_text')
                    ->label('Alt текст')
                    ->limit(50),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->headerActions([
                Action::make('bulkUpload')
                    ->label('Массовая загрузка')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->schema([
                        FileUpload::make('files')
                            ->multiple()
                            ->required()
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120)
                            ->directory('product-images')
                            ->disk('public')
                            ->visibility('public'),
                    ])
                    ->action(function (array $data) {
                        foreach ($data['files'] as $file) {

                            if ($file instanceof TemporaryUploadedFile) {
                                $path = $file->store('product-images', 'public');
                            } else {
                                $path = $file;
                            }

                            ProductImage::create([
                                'product_id' => $this->ownerRecord->id,
                                'path' => $path,
                                'alt_text' => '',
                                'order' => ProductImage::where('product_id', $this->ownerRecord->id)->max('order') + 1,
                            ]);
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->schema([
                        FileUpload::make('path')
                            ->label('Изображение')
                            ->image()
                            ->imageEditor()
                            ->maxSize(5120)
                            ->directory('product-images')
                            ->disk('public')
                            ->visibility('public'),

                        TextInput::make('alt_text')
                            ->label('Alt текст (для SEO)')
                            ->maxLength(255)
                            ->placeholder('Описание изображения')
                            ->helperText('Опишите что на картинке для поисковых систем')
                            ->required(),
                    ]),

                DeleteAction::make(),
            ]);
    }
}
