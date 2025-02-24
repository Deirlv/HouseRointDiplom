<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\HouseResource\Pages;
use App\Filament\Admin\Resources\HouseResource\RelationManagers;
use App\Models\House;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class HouseResource extends Resource
{
    protected static ?string $model = House::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->nullable(),
                Forms\Components\TextInput::make('price_per_night')
                    ->label('Price per Night')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('location')
                    ->label('Location')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_phone')
                    ->label('Contact Phone')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('contact_email')
                    ->label('Contact Email')
                    ->email()
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\Toggle::make('isAvailable')
                    ->label('Is Available')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->default(true)
                    ->helperText('Enable or disable the availability of the house.')
                    ->hiddenOn('create'),
                Forms\Components\Select::make('owner_id')
                    ->label('Owner')
                    ->relationship('owner', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\FileUpload::make('images')
                    ->label('Images')
                    ->multiple()
                    ->image()
                    ->maxFiles(5)
                    ->directory('house-images')
                    ->helperText('You can upload up to 5 images.')
                    ->nullable()
                    ->hiddenOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('owner.name')
                ->label('Owner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->formatStateUsing(fn ($state) => Str::limit($state, 50))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price_per_night')
                    ->label('Price per Night')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('images.image_path')
                ->label('Image')
                    ->limit(1)
                    ->circular()
                    ->size(40),

                Tables\Columns\IconColumn::make('isAvailable')
                    ->label('Availability')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->recordUrl(function ($record) {
                return route('houses.show', $record);
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHouses::route('/'),
            'create' => Pages\CreateHouse::route('/create'),
            'edit' => Pages\EditHouse::route('/{record}/edit'),
        ];
    }
}
