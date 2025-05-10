<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        $values = [
            'Kích thước' => ['Nhỏ', 'Vừa', 'Lớn'],
            'Ngôn ngữ' => ['Tiếng Việt', 'Tiếng Anh'],
            'Loại bìa' => ['Bìa mềm', 'Bìa cứng']
        ];

        foreach ($values as $attrName => $valArr) {
            $attribute = Attribute::where('name', $attrName)->first();

            foreach ($valArr as $val) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $val
                ]);
            }
        }
    }
}
