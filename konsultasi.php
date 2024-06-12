<?php
$connect = mysqli_connect("localhost", "root", "", "db_mila");
session_start();
function tampiltabel($arr)
{
	echo '<table id="myTable" class="table table-striped table-responsive" width="500" border="1" cellspacing="0" cellpadding="3">';
	for ($i = 0; $i < count($arr); $i++) {
		echo '<tr>';
		for ($j = 0; $j < count($arr[$i]); $j++) {
			echo '<td>' . @$arr[$i][$j] . '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}

function tampilbaris($arr)
{
	echo '<div style="overflow-x: auto" class="table-responsive">';
	echo '<table id="tabelBaris" class="table table-stripped" width="500" border="1">';
	echo '<thead>';
	echo '</thead>';
	echo '<tbody>';
	for ($i = 0; $i < count($arr); $i++) {
		echo '<tr>';
		echo '<td>D' . $i . '</td>';
		echo '<td>' . $arr[$i] . '</td>';
		echo "</tr>";
	}
	echo '</tbody>';
	echo '</table>';
	echo '</div>';
}

function tampilkolom($arr)
{
	echo '<div class="row">';
	echo '<div style="overflow-x: auto" class="table-responsive">';
	echo '<table border="1">';
	echo '<thead>';
	echo '<tr class="d-flex">';
	for ($i = 0; $i < count($arr); $i++) {
		echo '<td style="padding:10px;">' . $arr[$i] . '</td>';
	}
	echo "</tr>";
	echo '</thead>';
	echo '</table>';
	echo '</div>';
	echo '</div>';
}

if (!$_POST) {
?>
	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<div class="panel panel-info">
					<div class="panel-heading">Form Pengajuan Judul</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							<form action="" name="form1" method="post" class="form-horizontal form-bordered">
								<input type="hidden" name="mahasiswa" value="<?= $_SESSION['login'] ?>">
								<div class="form-body">
									<div class="form-group">
										<label class="control-label col-md-3">Judul Tugas Akhir</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="Q_judul" required>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">Latar Belakang</label>
										<div class="col-md-9">
											<textarea class="form-control" rows="7" name="Q_latar_belakang" required></textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3">Lokasi Penelitian</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="Q_lokasi" required>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-offset-3 col-md-9">
													<button type="submit" class="btn btn-success" name="cek_judul">Cek Judul</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } else {
	?>
		<?php
		if (isset($_POST['cek_judul'])) {
			$user = esc_field($_POST['mahasiswa']);
			$judul = esc_field($_POST['Q_judul']);
			$latar_belakang = esc_field($_POST['Q_latar_belakang']);
			$lokasi = esc_field($_POST['Q_lokasi']);
			$tahun = date("Y");

			if ($judul == '' || $latar_belakang == '') {
				print_msg("Tidak Boleh Kosong!");
			} else {
				$insert   = $db->query("INSERT INTO tb_proses_pengajuan VALUES (null,'$user','$judul','$latar_belakang','$lokasi','$tahun')");
				$id = $db->insert_id;
			}
			$_SESSION['id_proses'] = $id;
		}
		?>
		<div class="col-sm-12" id="perhitungan" style="display:none;">
			<div class="white-box">
				<?php
				// include composer autoloader
				require_once __DIR__ . '/vendor/autoload.php';

				// create stemmer
				$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
				$stemmer  = $stemmerFactory->createStemmer();

				//create stopword
				$stopWordRemoverFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
				$stopWordRemover = $stopWordRemoverFactory->createStopWordRemover();

				$D = array();
				$D_latar_belakang = array();
				$id = array();

				$D[0] = $_POST['Q_judul'];
				$D_latar_belakang[0] = $_POST['Q_latar_belakang'];
				$id[0] = 0;

				$i = 0;
				$q = mysqli_query($connect, "select * from tb_data_latih ORDER BY id_skripsi");
				while ($r = mysqli_fetch_array($q)) {
					$i++;
					$id[$i] = $r['id_skripsi'];
					$D[$i] = $r['judul'];
					$D_latar_belakang[$i] = $r['isi'];
				}

				echo "<br />";
				echo "<strong>";
				echo "Menampilkan Data Judul Yang disubmit beserta data latih yang telah diinput sebelumnya.<br/><br/><br/>";
				echo "</strong>";
				tampilbaris($D);
				// tampilbaris($D_latar_belakang);
				echo "<br />";

				//stopword stemming judul
				for ($i = 0; $i < count($D); $i++) {
					$D[$i] = $stopWordRemover->remove($D[$i]);
					$D[$i] = $stemmer->stem($D[$i]);
				}

				//stopword stemming latar belakang
				for ($i = 0; $i < count($D_latar_belakang); $i++) {
					$D_latar_belakang[$i] = $stopWordRemover->remove($D_latar_belakang[$i]);
					$D_latar_belakang[$i] = $stemmer->stem($D_latar_belakang[$i]);
				}

				echo "<br />";
				echo "<strong>";
				echo "Melakukan proses stopword dan stemming atau biasa disebut preprocessing.<br/><br/><br/>";
				echo "</strong>";
				tampilbaris($D);
				// tampilbaris($D_latar_belakang);
				echo "<br />";

				//view kata unik judul
				$kata = array();
				$semua = array();
				for ($i = 0; $i < count($D); $i++) {
					$kata[$i] = explode(" ", $D[$i]);
					$semua = array_merge($semua, $kata[$i]);
				}
				$semua = array_unique($semua);
				sort($semua);

				//view kata unik latar belakang
				$kata_latar_belakang = array();
				$semua_latar_belakang = array();
				for ($i = 0; $i < count($D_latar_belakang); $i++) {
					$kata_latar_belakang[$i] = explode(" ", $D_latar_belakang[$i]);
					$semua_latar_belakang = array_merge($semua_latar_belakang, $kata_latar_belakang[$i]);
				}
				$semua_latar_belakang = array_unique($semua_latar_belakang);
				sort($semua_latar_belakang);

				echo "<br />";
				echo "<strong>";
				echo "Menampilkan semua kata yang telah melalui proses stopword dan stemming<br/>";
				echo "</strong>";
				tampilkolom($semua);
				// tampilkolom($semua_latar_belakang);
				echo "<br />";

				//membuat matriks term frekuensi judul
				$tf = array();
				for ($i = 0; $i < count($D); $i++) {
					$freqs[$i] = array_count_values($kata[$i]);
					//print_r($freqs[$i]);
					for ($j = 0; $j < count($semua); $j++) {
						$tf[$j][$i] = 0 + @$freqs[$i][$semua[$j]];
					}
				}

				//membuat matriks term frekuensi latar belakang
				$tf_latar_belakang = array();
				for ($i = 0; $i < count($D_latar_belakang); $i++) {
					$freqs_latar_belakang[$i] = array_count_values($kata_latar_belakang[$i]);
					//print_r($freqs[$i]);
					for ($j = 0; $j < count($semua_latar_belakang); $j++) {
						$tf_latar_belakang[$j][$i] = 0 + @$freqs_latar_belakang[$i][$semua_latar_belakang[$j]];
					}
				}

				echo "<br />";
				echo "<strong>";
				echo "Setelah itu dicari TF (Term Frequency) yang berupa frekuensi banyaknya suatu kata muncul dalam suatu dokumen. Dihasilkan matrik TF seperti dibawah ini:<br/><br/><br/>";
				echo "</strong>";
				echo '<div style="overflow-x: auto">';
				echo '
				<table id="myTable" class="table table-striped" width="500" border="1" cellspacing="0" cellpadding="3">
					<thead>
						<tr>
							<th rowspan="2">Kata</th>
							<th colspan="' . count($D) . '">TF</th>
						</tr>
						<tr>';
				for ($i = 0; $i < count($D); $i++) {
					echo '<th>D' . $i;
					if ($i == 0) {
						echo '(Q)';
					}
					echo '</th>';
				}
				echo '
								</tr>
							</thead>
							<tbody>
						';
				for ($i = 0; $i < count($semua); $i++) {
					echo '<tr>';
					echo 	'<td>' . $semua[$i] . '</td>';
					for ($j = 0; $j < count($D); $j++) {
						echo '<td>' . $tf[$i][$j] . '</td>';
					}
					echo '</tr>';
				}
				echo '
					</tbody>
				</table>';
				echo '</div>';
				echo "<br />";

				//menghitung df judul
				$df = array();
				for ($i = 0; $i < count($semua); $i++) {
					$df[$i] = 0;
					for ($j = 0; $j < count($D); $j++) {
						if ($tf[$i][$j] > 0) {
							$df[$i]++;
						}
					}
				}

				//menghitung df latar belakang
				$df_latar_belakang = array();
				for ($i = 0; $i < count($semua_latar_belakang); $i++) {
					$df_latar_belakang[$i] = 0;
					for ($j = 0; $j < count($D_latar_belakang); $j++) {
						if ($tf_latar_belakang[$i][$j] > 0) {
							$df_latar_belakang[$i]++;
						}
					}
				}

				echo "<br />";
				echo "<strong>";
				echo "Kemudian dicari DF (Document Frequency) yang merupakan banyaknya frekuensi suatu kata muncul dalam semua dokumen:<br/><br/><br/>";
				echo "</strong>";
				echo '<div class="row">';
				echo '<div class="col-md-5">';
				echo '<div style="overflow-x: auto">';
				echo '
				<table id="myTable" class="table table-striped" width="500" border="1" cellspacing="0" cellpadding="3">
					<thead>
						<tr>
							<th rowspan="2">Kata</th>
							<th rowspan="2">DF</th>
						</tr>';
				echo '
					</thead>
					<tbody>
				';
				for ($i = 0; $i < count($semua); $i++) {
					echo '<tr>';
					echo 	'<td>' . $semua[$i] . '</td>';
					echo '<td>' . $df[$i] . '</td>';
					echo '</tr>';
				}
				echo '
					</tbody>
				</table>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo "<br />";

				//menghitung idf judul
				$idf = array();
				for ($i = 0; $i < count($semua); $i++) {
					$idf[$i] = log10((count($D) / $df[$i])) + 1;
				}

				//menghitung idf latar belakang
				$idf_latar_belakang = array();
				for ($i = 0; $i < count($semua_latar_belakang); $i++) {
					$idf_latar_belakang[$i] = log10((count($D_latar_belakang) / $df_latar_belakang[$i])) + 1;
				}

				echo "<br />";
				echo "<strong>";
				echo "Kemudian dicari IDF (Inverse Document Frequency) yang merupakan perhitungan bagaimana kata didistribusikan secara luas pada koleksi data latih yang bersangkutan. Rumus IDF adalah IDF= log(n/df) + 1:<br/><br/><br/>";
				echo "</strong>";
				echo '<div class="row">';
				echo '<div class="col-md-5">';
				echo '<div style="overflow-x: auto">';
				echo '
				<table id="myTable" class="table table-striped" width="500" border="1" cellspacing="0" cellpadding="3">
					<thead>
						<tr>
							<th rowspan="2">Kata</th>
							<th rowspan="2">IDF (log(n/df)+1)</th>
						</tr>';
				echo '
						</tr>
					</thead>
					<tbody>
				';
				for ($i = 0; $i < count($semua); $i++) {
					echo '<tr>';
					echo 	'<td>' . $semua[$i] . '</td>';
					echo '<td>' . $idf[$i] . '</td>';
					echo '</tr>';
				}
				echo '
					</tbody>
				</table>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo "<br />";

				//menghitung tf-idf judul
				$tf_idf = array();
				for ($i = 0; $i < count($semua); $i++) {
					for ($j = 0; $j < count($D); $j++) {
						$tf_idf[$i][$j] = $tf[$i][$j] * $idf[$i];
					}
				}

				//menghitung tf idf latar belakang
				$tf_idf_latar_belakang = array();
				for ($i = 0; $i < count($semua_latar_belakang); $i++) {
					for ($j = 0; $j < count($D_latar_belakang); $j++) {
						$tf_idf_latar_belakang[$i][$j] = $tf_latar_belakang[$i][$j] * $idf_latar_belakang[$i];
					}
				}

				echo "<br />";
				echo "<strong>";
				echo "Hitung nilai TF-IDF yang merupakan perkalian antara TF dan IDF<br/><br/><br/>";
				echo "</strong>";
				echo '<div style="overflow-x: auto">';
				echo '
				<table id="myTable" class="table table-striped" width="500" border="1" cellspacing="0" cellpadding="3">
					<thead>
						<tr>
							<th rowspan="2">Kata</th>
							<th colspan="' . count($D) . '">TF*IDF</th>
						</tr>
						<tr>';
				for ($i = 0; $i < count($D); $i++) {
					echo '<th>D' . $i;
					if ($i == 0) {
						echo '(Q)';
					}
					echo '</th>';
				}
				echo '
						</tr>
					</thead>
					<tbody>
				';
				for ($i = 0; $i < count($semua); $i++) {
					echo '<tr>';
					echo 	'<td>' . $semua[$i] . '</td>';
					for ($j = 0; $j < count($D); $j++) {
						echo '<td>' . $tf_idf[$i][$j] = $tf[$i][$j] * $idf[$i] . '</td>';
					}
					echo '</tr>';
				}
				echo '
					</tbody>
				</table>';
				echo '</div>';
				echo "<br />";

				//menghitung nilai D_Q judul
				$D_Q = array();
				for ($i = 0; $i < count($semua); $i++) {
					$D_Q[$i][$j] = 0;
					for ($j = 0; $j < count($D); $j++) {
						if ($j > 0) { //Q tidak punya..
							$D_Q[$i][$j] = $tf_idf[$i][0] * $tf_idf[$i][$j];
						}
					}
				}

				//menghitung nilai D_Q latar belakang
				$D_Q_latar_belakang = array();
				for ($i = 0; $i < count($semua_latar_belakang); $i++) {
					$D_Q_latar_belakang[$i][$j] = 0;
					for ($j = 0; $j < count($D_latar_belakang); $j++) {
						if ($j > 0) { //Q tidak punya..
							$D_Q_latar_belakang[$i][$j] = $tf_idf_latar_belakang[$i][0] * $tf_idf_latar_belakang[$i][$j];
						}
					}
				}

				echo "<br />";
				echo "<strong>";
				echo "Mencari DxQ yaitu perkalian skalar TF-IDF masing J terhadap TF-IDF Q, kemudian dicari totalannya.<br/><br/><br/>";
				echo "</strong>";
				echo '<div style="overflow-x: auto">';
				echo '
				<table id="myTable" class="table table-striped" width="500" border="1" cellspacing="0" cellpadding="3">
					<thead>
						<tr>
							<th rowspan="2">Kata</th>
							<th colspan="' . count($D) . '">D*Q</th>
						</tr>
						<tr>';
				for ($i = 0; $i < count($D); $i++) {
					echo '<th>D' . $i;
					if ($i == 0) {
						echo '(Q)';
					}
					echo '</th>';
				}
				echo '
						</tr>
					</thead>
					<tbody>
				';
				for ($i = 0; $i < count($semua); $i++) {
					echo '<tr>';
					echo 	'<td>' . $semua[$i] . '</td>';
					for ($j = 0; $j < count($D); $j++) {
						if ($j > 0) {
							echo '<td>' . $D_Q[$i][$j] = $tf_idf[$i][0] * $tf_idf[$i][$j] . '</td>';
						}
					}
					echo '</tr>';
				}
				echo '
					</tbody>
				</table>';
				echo '</div>';
				echo "<br />";

				//total perhitungan D_Q judul
				$total_D_Q = array();
				for ($i = 0; $i < count($D); $i++) {
					$total_D_Q[$i] = 0;
					if ($i > 0) {
						for ($j = 0; $j < count($semua); $j++) {
							$total_D_Q[$i] += $D_Q[$j][$i];
						}
					}
				}

				//total perhitungan D_Q latar belakang
				$total_D_Q_latar_belakang = array();
				for ($i = 0; $i < count($D_latar_belakang); $i++) {
					$total_D_Q_latar_belakang[$i] = 0;
					if ($i > 0) {
						for ($j = 0; $j < count($semua_latar_belakang); $j++) {
							$total_D_Q_latar_belakang[$i] += $D_Q_latar_belakang[$j][$i];
						}
					}
				}

				echo "<br />";
				echo "Total Perkalian Skalar D thd Q =<br/>";
				tampilbaris($total_D_Q);
				echo "<br />";

				//menghitung kuadrat D judul
				$tf_idf_kuadrat = array();
				for ($i = 0; $i < count($semua); $i++) {
					for ($j = 0; $j < count($D); $j++) {
						$tf_idf_kuadrat[$i][$j] = pow($tf_idf[$i][$j], 2);
					}
				}

				//menghitung kuadrat D latar belakang
				$tf_idf_kuadrat_latar_belakang = array();
				for ($i = 0; $i < count($semua_latar_belakang); $i++) {
					for ($j = 0; $j < count($D_latar_belakang); $j++) {
						$tf_idf_kuadrat_latar_belakang[$i][$j] = pow($tf_idf_latar_belakang[$i][$j], 2);
					}
				}

				echo "<br />";
				echo "TF-IDF Kuadrat =<br/>";
				tampiltabel($tf_idf_kuadrat);
				echo "<br />";

				//menghitung total kuadrat D judul
				$total_kuadrat = array();
				$akar_total_kuadrat = array();
				for ($i = 0; $i < count($D); $i++) {
					$total_kuadrat[$i] = 0;
					for ($j = 0; $j < count($semua); $j++) {
						$total_kuadrat[$i] += $tf_idf_kuadrat[$j][$i];
					}
					$akar_total_kuadrat[$i] = sqrt($total_kuadrat[$i]);
				}

				//menghitung total kuadrat D latar belakang
				$total_kuadrat_latar_belakang = array();
				$akar_total_kuadrat_latar_belakang = array();
				for ($i = 0; $i < count($D_latar_belakang); $i++) {
					$total_kuadrat_latar_belakang[$i] = 0;
					for ($j = 0; $j < count($semua_latar_belakang); $j++) {
						$total_kuadrat_latar_belakang[$i] += $tf_idf_kuadrat_latar_belakang[$j][$i];
					}
					$akar_total_kuadrat_latar_belakang[$i] = sqrt($total_kuadrat_latar_belakang[$i]);
				}

				echo "<br />";
				echo "Total TF-IDF Kuadrat =<br/>";
				tampilbaris($total_kuadrat);
				echo "<br />";

				echo "<br />";
				echo "Akar Total TF-IDF Kuadrat =<br/>";
				tampilbaris($akar_total_kuadrat);
				echo "<br />";

				//menghitung similiarity judul
				$similarity = array();
				for ($i = 0; $i < count($D); $i++) {
					$similarity[$i] = 0;
					if ($i > 0) {
						$similarity[$i] = $total_D_Q[$i] / ($akar_total_kuadrat[0] * $akar_total_kuadrat[$i]);
					}
				}

				//menghitung similarity latar belakang
				$similarity_latar_belakang = array();
				for ($i = 0; $i < count($D_latar_belakang); $i++) {
					$similarity_latar_belakang[$i] = 0;
					if ($i > 0) {
						$similarity_latar_belakang[$i] = $total_D_Q_latar_belakang[$i] / ($akar_total_kuadrat_latar_belakang[0] * $akar_total_kuadrat_latar_belakang[$i]);
					}
				}

				//menghitung similarity total
				$similarity_total = array();
				for ($i = 0; $i < count($D); $i++) {
					$similarity_total[$i] = 0;
					if ($i > 0) {
						$similarity_total[$i] = ($similarity[$i] + $similarity_latar_belakang[$i]) / 2;
					}
				}

				echo "<br />";
				echo "Similarity =<br/>";
				tampilbaris($similarity);
				echo "<br />";

				$no_rangking = array();
				$id_rangking = array();
				$D_rangking = array();
				$similarity_rangkingJud = array();
				$similarity_rangkingLat = array();
				$similarity_rangkingTotal = array();

				for ($i = 0; $i < count($D); $i++) {
					$no_rangking[$i] = $i;
					$id_rangking[$i] = $id[$i];
					$D_rangking[$i] = $D[$i];
					$similarity_rangkingJud[$i] = $similarity[$i];
					$similarity_rangkingLat[$i] = $similarity_latar_belakang[$i];
					$similarity_rangkingTotal[$i] = $similarity_total[$i];
				}

				for ($i = 0; $i < count($D); $i++) {
					for ($j = $i; $j < count($D); $j++) {
						if ($similarity_rangkingTotal[$j] > $similarity_rangkingTotal[$i]) {
							$tmp_no_rangking = $no_rangking[$i];
							$tmp_id_rangking = $id_rangking[$i];
							$tmp_D_rangking = $D_rangking[$i];
							$tmp_similarity_rangkingJud = $similarity_rangkingJud[$i];
							$tmp_similarity_rangkingLat = $similarity_rangkingLat[$i];
							$tmp_similarity_rangkingTotal = $similarity_rangkingTotal[$i];

							$no_rangking[$i] = $no_rangking[$j];
							$id_rangking[$i] = $id_rangking[$j];
							$D_rangking[$i] = $D_rangking[$j];
							$similarity_rangkingJud[$i] = $similarity_rangkingJud[$j];
							$similarity_rangkingLat[$i] = $similarity_rangkingLat[$j];
							$similarity_rangkingTotal[$i] = $similarity_rangkingTotal[$j];

							$no_rangking[$j] = $tmp_no_rangking;
							$id_rangking[$j] = $tmp_id_rangking;
							$D_rangking[$j] = $tmp_D_rangking;
							$similarity_rangkingJud[$j] = $tmp_similarity_rangkingJud;
							$similarity_rangkingLat[$j] = $tmp_similarity_rangkingLat;
							$similarity_rangkingTotal[$j] = $tmp_similarity_rangkingTotal;
						}
					}
				}

				echo "<br />";
				echo "No Rangking =<br/>";
				tampilbaris($no_rangking);
				echo "<br />";

				echo "<br />";
				echo "Rangking Kemiripan Tugas Akhir =<br/>";
				tampilbaris($D_rangking);
				echo "<br />";

				echo "<br />";
				echo "Rangking Similarity =<br/>";
				tampilbaris($similarity_rangkingTotal);
				echo "<br />";
				?>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="white-box">
				<div class="panel panel-info">
					<button onclick="document.getElementById('perhitungan').style.display='block';" class="btn btn-info">Cek Perhitungan</button>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<form action="" name="form1" method="post" class="form-horizontal form-bordered">
							<div class="panel-body">
								<div class="row">
									<p class="text-muted m-b-30 m-t-10">Hasil Analisa Deteksi Kemiripan Latar Belakang Usulan Judul menggunakan Metode TF-IDF (Term Frequency Inverse Document Frequency) & Cosine Similarity</p>
									<div class="table-responsive">
										<table id="tabelProses" class="table table-striped">
											<thead>
												<tr>
													<th>No.</th>
													<th>Judul Tugas Akhir</th>
													<th>Latar Belakang Tugas Akhir</th>
													<th>Nilai Kemiripan Judul</th>
													<th>Nilai Kemiripan Latar Belakang</th>
													<th>Nilai Hasil Kemiripan</th>
												</tr>
											</thead>
											<tbody>
												<?php
												for ($i = 0; $i < count($D_rangking); $i++) {
													if ($no_rangking[$i] != 0) {
														$q = mysqli_query($connect, "SELECT * FROM tb_data_latih WHERE id_skripsi = '" . $id_rangking[$i] . "' ORDER BY id_skripsi");
														$r = mysqli_fetch_array($q);
														$tingkat_mirip_judul = $similarity_rangkingJud[$i] * 100;
														$tingkat_mirip_latar = $similarity_rangkingLat[$i] * 100;
														$hasil = $similarity_rangkingTotal[$i] * 100;
												?>
														<tr>
															<td><?php echo "D" . $no_rangking[$i]; ?></td>
															<td><?php echo $r['judul']; ?></td>
															<td style><?php echo $r['isi']; ?></td>
															<td><?php echo round($tingkat_mirip_judul, 2) . "%"; ?></td>
															<td><?php echo round($tingkat_mirip_latar, 2) . "%"; ?></td>
															<td><?php echo round($hasil, 2) . "%"; ?></td>
														</tr>
												<?php
													}
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<?php
									$q = mysqli_query($connect, "SELECT * FROM tb_data_latih WHERE id_skripsi = '" . $id_rangking[0] . "' ORDER BY id_skripsi");
									$r = mysqli_fetch_array($q);
									$id_mirip = $r['id_skripsi'];
									$tingkat_mirip_judul = $similarity_rangkingJud[0] * 100;
									$tingkat_mirip_latar = $similarity_rangkingLat[0] * 100;
									$hasil = $similarity_rangkingTotal[0] * 100;
									?>
									<input type="hidden" name="id_skripsi" value="<?php echo $id_mirip; ?>">
									<input type="hidden" name="nilai_judul" value="<?php echo round($tingkat_mirip_judul, 2); ?>">
									<input type="hidden" name="nilai_latar" value="<?php echo round($tingkat_mirip_latar, 2); ?>">
									<input type="hidden" name="nilai_hasil" value="<?php echo round($hasil, 2); ?>">
									<p class="text-muted m-t-30">Hasilnya Tugas Akhir Yang Dibandingkan Paling Mirip Tugas Akhir Dengan Judul = <b name="judul_mirip"><?php echo $r["judul"]; ?></b> dengan Tingkat Kemiripan <b><?php echo round($hasil, 2) . "%" ?></b></p>
									<a type="submit" href="action.php?mod=batalkan-pengajuan&ID=<?= $_SESSION['id_proses'] ?>" role="button" class="btn btn-danger" style="display:inline-block;text-decoration: none;color:white">Batalkan Pengajuan</a>
									<?php if ($hasil >= 50) { ?>
										<button type="submit" name="konfirmasi_judul" class="btn btn-success" style="display:inline-block;text-decoration: none;color:white" disabled>Lanjutkan Pengajuan</button>
									<?php } else { ?>
										<button type="submit" name="konfirmasi_judul" class="btn btn-success" style="display:inline-block;text-decoration: none;color:white">Lanjutkan Pengajuan</button>
									<?php } ?>
								</div>
							</div>
						</form>
						<?php if (isset($_POST['konfirmasi_judul'])) {
							$proses_judul = $_SESSION['id_proses'];
							$data_latih = esc_field($_POST['id_skripsi']);
							$nilai_judul = esc_field($_POST['nilai_judul']);
							$nilai_latar = esc_field($_POST['nilai_latar']);
							$nilai_hasil = esc_field($_POST['nilai_hasil']);
							if ($proses_judul == "" || $data_latih == "" || $nilai_hasil == "") {
								print_msg("Tidak Boleh Kosong!");
							} else {
								$tgl_pengajuan = date("Y-m-d H:i:s");
								$insert = $db->query("INSERT INTO tb_pengajuan (id_pengajuan, proses_judul, judul_mirip, nilai_judul, nilai_latar_belakang, hasil_nilai, status, keterangan, tgl_pengajuan) VALUES (null, '$proses_judul', '$data_latih', '$nilai_judul', '$nilai_latar', '$nilai_hasil', 0, null, '$tgl_pengajuan')");
								alert("Menunggu Proses Persetujuan Prodi");
								redirect_js("?mod=pengajuan");
							}
						} ?>
					</div>
				</div>
			</div>
		</div>
	<?php
}
	?>
	</div>