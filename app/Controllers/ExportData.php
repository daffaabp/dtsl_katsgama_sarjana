<?php
// require 'vendor/autoload.php';

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet as Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportData extends BaseController
{

    public function excel()
    {
        $req = $this->request->getVar();
        $data['req'] = $req;

        $alumniModel = new \App\Models\AlumniModel();
        $akademikModel = new \App\Models\AkademikModel();
        $data_alumni = $alumniModel->export_alumni($req)->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'WA');
        $sheet->setCellValue('E1', 'Telp');
        $sheet->setCellValue('F1', 'Bidang Pekerjaan');
        $sheet->setCellValue('G1', 'Instansi');
        $sheet->setCellValue('H1', 'Jabatan');
        $sheet->setCellValue('I1', 'Propinsi');
        $sheet->setCellValue('J1', 'Alamat');
        $sheet->setCellValue('K1', 'Tahun Wisuda');
        $sheet->setCellValue('L1', 'Bulan Wisuda');

        $sheet->setCellValue('M1', 'Riwayat Akademik');

        $i = 1;
        $sh = 2;
        foreach ($data_alumni as $al) {
            // echo $i . ' - ';
            $sheet->setCellValue('A' . $sh, $i);

            // echo $al['nama'] . ' - ';
            $sheet->setCellValue('B' . $sh, (isset($al['nama']) && !empty($al['nama'])) ? $al['nama'] : '-');

            // echo $al['email'] . ' - ';
            $sheet->setCellValue('C' . $sh, (isset($al['email']) && !empty($al['email'])) ? $al['email'] : '-');

            // echo $al['nowa'] . ' - ';
            $sheet->setCellValue('D' . $sh, (isset($al['nowa']) && !empty($al['nowa'])) ? $al['nowa'] : '-');

            // echo $al['notelp'] . ' - ';
            $sheet->setCellValue('E' . $sh, (isset($al['notelp']) && !empty($al['notelp'])) ? $al['notelp'] : '-');

            // echo $al['occupation_id'] . ' - ';
            $sheet->setCellValue('F' . $sh, (isset($al['occupation']) && !empty($al['occupation'])) ? $al['occupation'] : '-');

            // echo $al['instansi'] . ' - ';
            $sheet->setCellValue('G' . $sh, (isset($al['instansi']) && !empty($al['instansi'])) ? $al['instansi'] : '-');

            // echo $al['jabatan'] . ' - ';
            $sheet->setCellValue('H' . $sh, (isset($al['jabatan']) && !empty($al['jabatan'])) ? $al['jabatan'] : '-');

            // echo $al['prop_id'] . ' - ';
            $sheet->setCellValue('I' . $sh, (isset($al['propinsi']) && !empty($al['propinsi'])) ? $al['propinsi'] : '-');

            // echo $al['alamat'] . ' - ';
            $sheet->setCellValue('J' . $sh, (isset($al['alamat']) && !empty($al['alamat'])) ? $al['alamat'] : '-');

            $sheet->setCellValue('K' . $sh, (isset($al['twisuda']) && !empty($al['twisuda'])) ? $al['twisuda'] : '-');

            if (isset($al['blnwisuda']) && !empty($al['blnwisuda'])) {
                $blnwisuda = $al['blnwisuda'];
                switch ($blnwisuda) {
                    case 1:
                        $blnwisuda = 'Januari';
                        break;
                    case 2:
                        $blnwisuda = 'Februari';
                        break;
                    case 3:
                        $blnwisuda = 'Maret';
                        break;
                    case 4:
                        $blnwisuda = 'April';
                        break;
                    case 5:
                        $blnwisuda = 'Mei';
                        break;
                    case 6:
                        $blnwisuda = 'Juni';
                        break;
                    case 7:
                        $blnwisuda = 'Juli';
                        break;
                    case 8:
                        $blnwisuda = 'Agustus';
                        break;
                    case 9:
                        $blnwisuda = 'September';
                        break;
                    case 10:
                        $blnwisuda = 'Oktober';
                        break;
                    case 11:
                        $blnwisuda = 'November';
                        break;
                    case 12:
                        $blnwisuda = 'Desember';
                        break;
                    default:
                        $blnwisuda = '-';
                }
                $sheet->setCellValue('L' . $sh, $blnwisuda);
            } else {
                $sheet->setCellValue('L' . $sh, '-');
            }

            // echo 'S1' . ' - ';
            $riwayat_akademik = $akademikModel->where('idorg', $al['id'])->findAll();

            if (isset($riwayat_akademik[0])) {
                $ra = $riwayat_akademik[0];
                $detail = '';
                if ((isset($ra['jenjang']) && !empty($ra['jenjang']))) {
                    $detail .=  'Jenjang: ';
                    $detail .=   $ra['jenjang'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['universitas']) && !empty($ra['universitas']))) {
                    $detail .=  'Universitas: ';
                    $detail .=   $ra['universitas'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['tmasuk']) && !empty($ra['tmasuk']))) {
                    $detail .=  'Tahun masuk: ';
                    $detail .=   $ra['tmasuk'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['tlulus']) && !empty($ra['tlulus']))) {
                    $detail .=  'Tahun lulus: ';
                    $detail .=   $ra['tlulus'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['prodi']) && !empty($ra['prodi']))) {
                    $detail .=  'Prodi: ';
                    $detail .=   $ra['prodi'];
                    $detail .=  ' - ';
                }
                $sheet->setCellValue('M' . $sh, $detail);
            }

            if (isset($riwayat_akademik[1])) {
                $ra = $riwayat_akademik[1];
                $detail = '';
                if ((isset($ra['jenjang']) && !empty($ra['jenjang']))) {
                    $detail .=  'Jenjang: ';
                    $detail .=   $ra['jenjang'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['universitas']) && !empty($ra['universitas']))) {
                    $detail .=  'Universitas: ';
                    $detail .=   $ra['universitas'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['tmasuk']) && !empty($ra['tmasuk']))) {
                    $detail .=  'Tahun masuk: ';
                    $detail .=   $ra['tmasuk'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['tlulus']) && !empty($ra['tlulus']))) {
                    $detail .=  'Tahun lulus: ';
                    $detail .=   $ra['tlulus'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['prodi']) && !empty($ra['prodi']))) {
                    $detail .=  'Prodi: ';
                    $detail .=   $ra['prodi'];
                    $detail .=  ' - ';
                }
                $sheet->setCellValue('N' . $sh, $detail);
            }

            if (isset($riwayat_akademik[1])) {
                $ra = $riwayat_akademik[1];
                if ((isset($ra['jenjang']) && !empty($ra['jenjang']))) {
                    $detail .=  'Jenjang: ';
                    $detail .=   $ra['jenjang'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['universitas']) && !empty($ra['universitas']))) {
                    $detail .=  'Universitas: ';
                    $detail .=   $ra['universitas'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['tmasuk']) && !empty($ra['tmasuk']))) {
                    $detail .=  'Tahun masuk: ';
                    $detail .=   $ra['tmasuk'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['tlulus']) && !empty($ra['tlulus']))) {
                    $detail .=  'Tahun lulus: ';
                    $detail .=   $ra['tlulus'];
                    $detail .=  ' - ';
                }
                if ((isset($ra['prodi']) && !empty($ra['prodi']))) {
                    $detail .=  'Prodi: ';
                    $detail .=   $ra['prodi'];
                    $detail .=  ' - ';
                }
                $sheet->setCellValue('O' . $sh, $detail);
            }
            $i++;
            $sh++;
        }


        // Set judul file excel nya
        $sheet->setTitle("Data Alumni");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="DataAlumni.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
