
<?php
    include_once("config.php");
    $ham = $_POST["ham"];
    switch($ham){
        case 'LayDanhSachMenu':
            $ham(); // Lay danh sach menu
            break;
        case 'DangKyThanhVien':
            $ham();
            break;
        case 'KiemTraDangNhap':
            $ham();
            break;
    }

    function KiemTraDangNhap(){
        global $conn;
        if(isset($_POST["tendangnhap"]) || isset($_POST["matkhau"])){
            $tendangnhap = $_POST["tendangnhap"];
            $matkhau = $_POST["matkhau"];
        }

        $truyvan = "SELECT * FROM nhanvien WHERE TENDANGNHAP='".$tendangnhap."' AND MATKHAU='".$matkhau."'";
        $ketqua = mysqli_query($conn,$truyvan);
        $demdong = mysqli_num_rows($ketqua);
        if($demdong >=1){
            $tennv = "";
            while ($dong = mysqli_fetch_array($ketqua)) {
                $tennv = $dong["TENNV"];
            }
            echo "{ ketqua : true, tennv : \"".$tennv."\" }";
        }else{
            echo "{ ketqua : false }";
        }

    }
    function DangKyThanhVien(){
        global $conn;
        if(isset($_POST["tennv"]) || isset($_POST["tendangnhap"]) || isset($_POST["matkhau"]) || isset($_POST["maloainv"]) || isset($_POST["emaildocquyen"])){
            $tennv = $_POST["tennv"];
            $tendangnhap = $_POST["tendangnhap"];
            $matkhau = $_POST["matkhau"];
            $maloainv = $_POST["maloainv"];
            $emaildocquyen = $_POST["emaildocquyen"];
        }

        $truyvan = "SELECT * FROM nhanvien WHERE TENDANGNHAP='".$tendangnhap."' ";
        $checkdk = mysqli_query($conn,$truyvan);
        $demdong = mysqli_num_rows($checkdk);
        if($demdong >=1){
            echo "{ ketqua : false }";
        }else{
            $truyvan = "INSERT INTO nhanvien (TENNV, TENDANGNHAP,MATKHAU,MALOAINV,EMAILDOCQUYEN) VALUES ('".$tennv."', '".$tendangnhap."', '".$matkhau."','".$maloainv."','".$emaildocquyen."') " ;
            if(mysqli_query($conn,$truyvan)){
                echo "{ ketqua : true, tennv : \"".$tennv."\" }";
            }else{
                echo "{ ketqua : false }".mysqli_error($conn);
            }
        }

        mysqli_close($conn);
    }

    function LayDanhSachMenu(){
        global $conn;
        if(isset($_POST["maloaicha"]))
            $maloaicha = $_POST["maloaicha"];

        $truyvancha = "SELECT *  FROM loaisanpham WHERE MALOAI_CHA = ".$maloaicha;
        $ketqua = mysqli_query($conn,$truyvancha);
        $chuoijson = array();
        echo "{";
        echo "\"LOAISANPHAM\":";
        if($ketqua){
            while ($dong=mysqli_fetch_array($ketqua)) {
                // cách 1
                $chuoijson[] = $dong;

                // end cách 1
                // laydanhsachloaisp($dong["MALOAISP"]);

                //cách 2
                // array_push($chuoijson, array("TENLOAISP"=>$dong["TENLOAISP"],'MALOAISP' => $dong["MALOAISP"]));
                //end cách 2
            }

            echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
        }
        echo "}";

        mysqli_close($conn);
    }
?>
