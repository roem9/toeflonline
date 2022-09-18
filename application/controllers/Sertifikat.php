<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikat extends CI_Controller {

    
    public function __construct(){
        parent::__construct();
        $this->load->model("Main_model");
    }
    
    public function no($id){
        $peserta = $this->Main_model->get_one("peserta_toefl", ["md5(id)" => $id]);
        $peserta['link'] = $this->Main_model->get_one("config", ['field' => "web admin"]);
        if($peserta){
            $tes = $this->Main_model->get_one("tes", ["id_tes" => $peserta['id_tes']]);
            $peserta['nama'] = $peserta['nama'];
            $peserta['title'] = "Sertifikat ".$peserta['nama'];
            $peserta['t4_lahir'] = ucwords(strtolower($peserta['t4_lahir']));
            $peserta['hari'] = date('d', strtotime($tes['tgl_tes']));
            $peserta['tahun'] = date('y', strtotime($tes['tgl_tes']));
            $peserta['bulan'] = date('m', strtotime($tes['tgl_tes']));
            $peserta['istima'] = poin("Listening", $peserta['nilai_listening']);
            $peserta['tarakib'] = poin("Structure", $peserta['nilai_structure']);
            $peserta['qiroah'] = poin("Reading", $peserta['nilai_reading']);
            $peserta['tgl_tes'] = $tes['tgl_tes'];
            $peserta['tgl_berakhir'] = date('Y-m-d', strtotime('+1 year', strtotime($tes['tgl_tes'])));

            $peserta['link_foto'] = config();

            $skor = ((poin("Listening", $peserta['nilai_listening']) + poin("Structure", $peserta['nilai_structure']) + poin("Reading", $peserta['nilai_reading'])) * 10) / 3;
            $peserta['skor'] = $skor;

            // $peserta['no_doc'] = "{$peserta['no_doc']}/TOAFL/ACP/{$peserta['bulan']}/{$peserta['tahun']}";
            // $peserta['no_doc'] = "{$peserta['tahun']}/{$peserta['no_doc']}";

            $peserta['no_doc'] = "{$peserta['tahun']}/{$peserta['bulan']}-{$peserta['hari']}-{$peserta['no_doc']}";
        }

        // $this->load->view("pages/layout/header-sertifikat", $peserta);
        // $this->load->view("pages/soal/".$page, $data);
        $peserta['background'] = $this->Main_model->get_one("config", ["field" => 'background']);
        $this->load->view("pages/sertifikat", $peserta);
        // $this->load->view("pages/layout/footer");
    }

    public function peserta($no = "no", $id){
        $peserta = $this->Main_model->get_one("peserta_bussiness", ["md5(id_peserta)" => $id]);
        $peserta['link'] = $this->Main_model->get_one("config", ['field' => "web admin"]);
        if($peserta){
            $tes = $this->Main_model->get_one("tes_peserta_bussiness", ["id_peserta" => $peserta['id_peserta'], "status" => "on"]);
            $peserta['nama'] = $peserta['nama_peserta'];
            $peserta['title'] = "Sertifikat ".$peserta['nama_peserta'];
            $peserta['t4_lahir'] = ucwords(strtolower($peserta['t4_lahir']));
            $peserta['tahun'] = date('y', strtotime($tes['tgl_tes']));
            $peserta['bulan'] = date('m', strtotime($tes['tgl_tes']));
            $peserta['hari'] = date('d', strtotime($tes['tgl_tes']));
            $peserta['istima'] = poin("Listening", $tes['nilai_listening']);
            $peserta['tarakib'] = poin("Structure", $tes['nilai_structure']);
            $peserta['qiroah'] = poin("Reading", $tes['nilai_reading']);
            $peserta['tgl_tes'] = $tes['tgl_tes'];
            $peserta['skor'] = round($tes['skor_toefl']);
            // $peserta['tgl_berakhir'] = date('Y-m-d', strtotime('+6 months', strtotime($tes['tgl_tes'])));

            // $skor = ((poin("Listening", $tes['nilai_listening']) + poin("Structure", $tes['nilai_structure']) + poin("Reading", $tes['nilai_reading'])) * 10) / 3;
            // $peserta['skor_toefl'] = $peserta['skor_toefl'];

            $peserta['no_doc'] = "{$peserta['tahun']}/{$peserta['bulan']}-{$peserta['hari']}-{$peserta['no_doc']}";
        }

        // $this->load->view("pages/layout/header-sertifikat", $peserta);
        // $this->load->view("pages/soal/".$page, $data);
        $peserta['background'] = $this->Main_model->get_one("config", ["field" => 'background']);
        $this->load->view("pages/sertifikat", $peserta);
        // $this->load->view("pages/layout/footer");
    }
}

/* End of file Sertifikat.php */
