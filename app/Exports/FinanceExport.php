<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Collection;

class FinanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize, WithColumnFormatting
{
    protected $finances;

    public function __construct($finances)
    {
        $this->finances = $finances;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->finances;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Date',
            'Student Name',
            'Student Code',
            'Transaction Type',
            'Amount (Rp)',
            'Status',
            'Due Date',
            'Payment Date',
            'Description',
            'Receipt Status'
        ];
    }

    /**
     * @param mixed $finance
     * @return array
     */
    public function map($finance): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $finance->date ? $finance->date->format('d/m/Y') : '-',
            $finance->student ? $finance->student->name : '-',
            $finance->student ? $finance->student->unique_code : '-',
            $this->formatType($finance->type),
            $finance->amount, // Keep as number for Excel formatting
            $this->formatStatus($finance->status),
            $finance->due_date ? $finance->due_date->format('d/m/Y') : '-',
            $finance->payment_date ? $finance->payment_date->format('d/m/Y H:i') : '-',
            $finance->description ?? '-',
            $finance->payment_receipt ? 'Ada Bukti' : 'Belum Ada'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Get the highest row and column
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        return [
            // Header styles
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['argb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '4472C4']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000']
                    ]
                ]
            ],

            // Data rows
            "A2:{$highestColumn}{$highestRow}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'CCCCCC']
                    ]
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],

            // Number column alignment
            "A2:A{$highestRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            // Date columns alignment
            "B2:B{$highestRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            // Amount column alignment and formatting
            "F2:F{$highestRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                ],
                'font' => [
                    'bold' => true
                ],
                'numberFormat' => [
                    'formatCode' => '#,##0'
                ]
            ],

            // Status column alignment
            "G2:G{$highestRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            // Due date and payment date alignment
            "H2:I{$highestRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            // Receipt status alignment
            "K2:K{$highestRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 12,  // Date
            'C' => 25,  // Student Name
            'D' => 15,  // Student Code
            'E' => 18,  // Transaction Type
            'F' => 15,  // Amount
            'G' => 12,  // Status
            'H' => 12,  // Due Date
            'I' => 18,  // Payment Date
            'J' => 30,  // Description
            'K' => 15,  // Receipt Status
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Finance Report ' . now()->format('d-m-Y');
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'F' => '#,##0', // Amount column with thousand separator
        ];
    }

    /**
     * Format transaction type
     */
    private function formatType($type): string
    {
        return match ($type) {
            'tuition' => 'Biaya Kursus',
            'registration' => 'Biaya Pendaftaran',
            'material' => 'Biaya Materi',
            'exam' => 'Biaya Ujian',
            default => ucfirst($type)
        };
    }

    /**
     * Format status
     */
    private function formatStatus($status): string
    {
        return match ($status) {
            'pending' => 'Menunggu',
            'paid' => 'Lunas',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($status)
        };
    }
}
