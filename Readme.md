# Medan Software - Max Miner


## Perhitungan

1. Membaca daftar transaksi
2. Menghitung nilai frekuensi setiap item produk
3. Menghitung nilai support dari setiap frekuensi item
4. Mengeliminasi data frekuensi item yang lebih kecil dari nilai support
5. Menggabungkan dua item set dari daftar produk secara unik
4. Mencari nilai support dan confidence dari setiap item yang telah digabungkan
5. Mengeliminasi data frekuensi item yang telah di gabungan
6. Membuat aturan asosiasi dari hasil data frekuensi item yang telah di eliminasi

## Flowchart Max Miner

![max-miner drawio](https://user-images.githubusercontent.com/11814324/155153448-67cbe68d-1be1-457d-ab51-fd8f38deb991.png)

## Database Relationship

![ERD](https://github.com/user-attachments/assets/44b8e043-ec17-4bb2-9c67-c1e227fada50)

```txt
user {
	id integer(2) pk increments
	role integer
	email string(40)
	username string(50)
	password string(40)
	full_name string(40)
	photo string(100)
}

order {
	id integer(4) pk increments
	uid varchar(10)
	item integer(1)
	total decimal
	date date
	time time
}

product {
	id integer(2) pk increments
	type integer
	name string(80)
	image string(255)
	price decimal
}

cart {
	id integer(4) pk increments
	order_id integer(4) > order.id
	product_id integer(4) > product.id
	name varchar(80)
	quantity integer(2)
	price decimal
	subtotal decimal
}
```
