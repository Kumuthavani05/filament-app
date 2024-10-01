<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductImageResource\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput; // Correct import for TextInput
use Filament\Forms\Components\Textarea; // Correct import for TextInput
use Filament\Forms\Components\Toggle; // Correct import for TextInput
use Filament\Forms\Components\FileUpload; // Correct import for TextInput
use Filament\Forms\Components\Repeater;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')->required(),
            TextInput::make('price')->numeric()->required(),
            Textarea::make('description')->nullable(),
            Toggle::make('status')
            ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\BooleanColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

//     public static function mutateFormDataBeforeCreate(array $data): array
// {
//     $images = $data['images'] ?? [];

//     unset($data['images']);

//     $product = Product::create($data);

//     foreach ($images as $image) {
//         dd(123);
//         $product->images()->create(['image_path' => $image->store( 'storage')]);
//     }

//     return $data;
// }
}
