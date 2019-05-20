<?php
/**
 * Created by PhpStorm.
 * User: owlting
 * Date: 2019-05-16
 * Time: 14:49
 */

namespace App\Export;

use App\Image;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ImageExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    /**
     * @return Collection
     */
    public function collection()
    {
        return Image::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'id',
            'file_name',
            'size',
            'url',
            'user_id'
        ];
    }
}