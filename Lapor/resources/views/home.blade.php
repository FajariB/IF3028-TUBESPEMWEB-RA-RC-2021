<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan</title>
    <link rel="stylesheet" href="home.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Poppins' rel='stylesheet' type='text/css'>
    <script>
        function cari() {
            var word = document.getElementById("cari").value;
            var data = new FormData();
            data.append("keyword", word);
            console.log(data.get('keyword'));
            axios.post('cari', data).then(function(response){
                console.log(response.data);
                if(response.data == ""){
                    alert("data tidak ditemukan!");
                }
                else{
                    document.getElementById("search").innerHTML = response.data;
                }
            });
        }
        function buat() {
            axios.get('form').then(response => {
                document.getElementById("root").innerHTML = response.data;
            })
        }
        function home() {
            axios.get('home').then(response => {
                document.getElementById("root").innerHTML = response.data;
            })
        }
        function up() {
            var contents = document.getElementById("contents").value;
            var aspect = document.getElementById("aspect").value;
            var file = document.getElementById("file");
            if(file.files.length > 0){
                file = file.files[0];
            }
            var data = new FormData();
            data.append("contents", contents);
            data.append("aspect", aspect);
            data.append("file", file);
            axios.post('create', data).then(response => {
                alert("Data berhasil dibuat!");
                home();
            });
        }
        function detail(id) {
            axios.get('detail/'+id).then(response => {
                document.getElementById("root").innerHTML = response.data;
            })
        }
        function hapus(id) {
            var conf = confirm("Anda yakin ingin menghapus data?");
            if(conf){
                var data = new FormData();
                data.append("id", id);
                axios.post("delete", data).then(response => {
                    alert("data sukses dihapus");
                    home();
                });
            }
        }
        function edit(id) {
            var data = new FormData();
            data.append("id", id);
            axios.post("edit", data).then(response => {
                document.getElementById("root").innerHTML = response.data;
            });
        }
        function update(id) {
            var contents = document.getElementById("contents").value;
            var aspect = document.getElementById("aspect").value;
            var file = document.getElementById("file");
            // if(file.files.length > 0){
            //     file = file.files[0];
            // }
            var data = new FormData();
            data.append("id", id);
            data.append("contents", contents);
            data.append("aspect", aspect);
            if(file.files.length > 0){
                data.append("file", file.files[0]);
            }
            axios.post('update', data).then(response => {
                alert("Update Sukses!");
                home();
            });
        }
    </script>
</head>
<style>
    
</style>
<body>
    <div class="nav"> 
        <nav>
            <ul>
                <li><a href="{{url('about')}}">tentang lapor!</a> </li>
                <li><p class='font2'><b onclick="home()" id="link_home">Simple LAPOR!</b></p> </li>
            </ul>
        </nav>
    </div>
    <div class="container" >
        <div style="background-image: url('{{asset("image/bg-atas.png")}}');" class="test"></div>
        <center><h1>Layanan Aspirasi dan Pengaduan Online</h1></center>
        <center><p>Sampaikan laporan Anda secara langsung </p></center>
        <br/>
        </br>
        </br>
        <div id="root">
            <div class="kotak">
                <center>
                    <input type="text" class="input" id="cari" /><button class="src" onclick="cari()"><img class="kaca" src="{{asset('image/icon-search.png')}}" alt="" /><span class="desc">Cari</span></button>
                </center>
            </div>

            <div class="buat">
                <center><a class="buatlap" href="#laporan" onclick="buat()">Buat Laporan</a></center>
            </div>
            <br />
            <br />
            <div>
                    <h1>Laporan dan Komentar</h1>
                    <hr />
                    <div id="search">
                        @foreach ($data as $item)
                            <div>
                                <p>
                                    {{ $item->contents }}
                                </p>
                                <?php $a = explode("/", $item->file); ?>
                                <div class="lampiran">
                                    <p>Lampiran: {{ count($a) >= 2 ? $a[1] : ""}}</p>
                                </div>

                                <div class="waktu">
                                    <p>Waktu: {{ $item->created_at }}</p>
                                </div>
                                <div class="lihat" onclick="detail({{$item->id}})">
                                    <p>Lihat Selengkapnya ></p>
                                </div>

                                <div class="clearfix"></div>
                                <hr />
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>

</body>

</html>
