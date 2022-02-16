require('dotenv').config(); // Load .env file for environment

const express = require('express');
const app = express();
const cors = require('cors');
const http = require('http').createServer(app);
const flash = require('connect-flash');
const express_session = require('express-session');
const FileStore = require('session-file-store')(express_session);
const moment_timezone = require('moment-timezone');
const moment_duration = require('moment-duration-format');
const session = express_session({
	store: new FileStore(),
	secret: 'my-secret-key',
	resave: true,
	saveUninitialized: true,
	cookie: { secure: false, maxAge: Date.now() + (30 * 86400 * 1000) }
});

global.DB;
global.Models;
global.ViewEngine = require(__dirname+'/view-engine');
global.moment = require('moment');

const Initialize_Database = () => {
	return new Promise((resolve, reject) => {
		var config = require('./config/database');
		const { host, port, username, password, database, dbdriver, timezone, debugging } = config;
		const { Sequelize, Op, Model, DataTypes } = require('sequelize');
		const connection = new Sequelize.Sequelize(database, username, password, {
			host: host,
			port: (port !== 3306)?port:3306,
			dialect: dbdriver,
			logging: debugging
		});

		// load models
		const models = require(__dirname+'/models/');
		const models_name = Object.keys(models);

		for (var key = 0; key < models_name.length; key ++) {
			var name = models_name[key];
			var model = models[name](DataTypes);

			name = (model.config !== undefined && model.config.modelName !== undefined)?model.config.modelName:name;
			connection.define(name, model.fields, Object.assign({
				tableName: name,
				freezeTableName: true,
				underscored: true,
				createdAt: 'created_at',
				updatedAt: 'updated_at',
				charset: 'utf8mb4',
				collate: 'utf8mb4_unicode_ci'
			}, model.config));
		}

		for (var key = 0; key < models_name.length; key ++) {
			var name = models_name[key];
			var model = models[name](DataTypes);

			if (model.associate !== undefined && model.associate.length > 0) {
				model.associate.forEach((relation, key) => {
					// removing object keys : type & model to show associations config only
					var associate = model.associate.map((associate, k) => {
						var new_object = {}
						var object_keys  = Object.keys(associate);
						for (var i = 0; i < object_keys.length; i++) {
							if (['type', 'model'].indexOf(object_keys[i]) == -1) {
								new_object[object_keys[i]] = associate[object_keys[i]];
							}
						}

						return new_object;
					});

					connection.models[name][relation.type](connection.models[[model.associate[key].model]], associate[key]);
				});
			}
		}

		connection.sync({ [process.env.DB_MODE]: false }).then((conn) => {
			global.Models = Object.assign(connection.models, global.Models);
			resolve({ connection, Sequelize, Op, Model, DataTypes });
		});
	});
}



Initialize_Database().then(async init => {
	DB = init;

	var random_array = function(array) {
		var random = Math.floor(Math.random() * array.length);
		return array[random];
	}

	var random_integer = function(min, max) {
		min = Math.ceil(min);
		max = Math.floor(max);
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	var random_string = (length) => {
		var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'.split('');
		if (!length) {
			length = Math.floor(Math.random() * chars.length);
		}

		var str = '';
			for (var i = 0; i < length; i++) {
			str += chars[Math.floor(Math.random() * chars.length)];
		}

		return str;
	}

	var array_object_find_value = (arrayName, searchKey, searchValue) => {
		let find = arrayName.findIndex(i => i[searchKey] == searchValue);
		return (find !== -1)?find:false;
	}

	// await Models.product.bulkCreate([
	// 	{
	// 		name: 'Chitato',
	// 		type: 'food',
	// 		image: null,
	// 		price: 18700
	// 	},
	// 	{
	// 		name: 'Qtela',
	// 		type: 'food',
	// 		image: null,
	// 		price: 14150
	// 	},
	// 	{
	// 		name: 'Jetz',
	// 		type: 'food',
	// 		image: null,
	// 		price: 21145
	// 	},
	// 	{
	// 		name: 'Chiki',
	// 		type: 'food',
	// 		image: null,
	// 		price: 19500
	// 	},
	// 	{
	// 		name: 'Maxicorn',
	// 		type: 'food',
	// 		image: null,
	// 		price: 28000
	// 	},
	// 	{
	// 		name: 'Indomilk',
	// 		type: 'drink',
	// 		image: null,
	// 		price: 16700
	// 	},
	// 	{
	// 		name: 'Ichi Ocha',
	// 		type: 'drink',
	// 		image: null,
	// 		price: 15000
	// 	},
	// 	{
	// 		name: 'Club',
	// 		type: 'drink',
	// 		image: null,
	// 		price: 8000
	// 	},
	// 	{
	// 		name: 'Fruitamin',
	// 		type: 'drink',
	// 		image: null,
	// 		price: 12600
	// 	}
	// ]);

	var food = await Models.product.findAll({ where: { type: 'food' } });
	var drink = await Models.product.findAll({ where: { type: 'drink' } });
	var date = moment().year(2021).month(0).date(1).hours(0).minutes(0).seconds(0).milliseconds(0);
	for (i = 0; i < 1000; i++) {
		date.add(random_array([random_integer(2, 4), random_integer(4, 6), random_integer(2, 8)]), 'hour');

		var total_price 	= [];
		var total_items 	= [];
			total_price[i] 	= 0;
			total_items[i] 	= random_integer(2, 6);


		var order = new Array();
		var product = new Array();

		var product_1 = await Models.product.findOne({ where: { id: 1 } });
		var product_7 = await Models.product.findOne({ where: { id: 7 } });

		var cart_count_1 = await Models.cart.count({
			where: {
				product_id: 1
			}
		});

		var cart_count_7 = await Models.cart.count({
			where: {
				product_id: 7
			}
		});

		order[i] = await Models.order.create({
			uid: random_string(10),
			item: total_items[i],
			total: null,
			date: date.format('YYYY-MM-DD'),
			time: date.format('HH:mm:ss')
		});

		product[i] = new Array();

		var yes_no = random_array(['yes', 'no']);
		if (yes_no == 'yes') {
			var mix_product = (i) => {
				var products = new Array();
				for (mixer = 0; mixer+=1;) {
					if (product[i].length == total_items[i]) {
						return products;
					} else {
						if (product[i].indexOf(1) == -1) {
							product[i].push(1);
							products.push(product_1);
						} else if (product[i].indexOf(7) == -1) {
							product[i].push(7);
							products.push(product_7);
						} else {
							var item = random_array(['drink', 'food']);
							var random_product = random_array(eval(item));
							if (product[i].indexOf(random_product.get('id')) == -1) {
								product[i].push(random_product.get('id'));
								products.push(random_product);
							}
						}
					}
				}
			}
		} else {
			var mix_product = (i) => {
				var products = new Array();
				for (mixer = 0; mixer+=1;) {
					if (product[i].length == total_items[i]) {
						return products;
					} else {
						var item = random_array(['drink', 'food']);
						var random_product = random_array(eval(item));
						if (product[i].indexOf(random_product.get('id')) == -1) {
							product[i].push(random_product.get('id'));
							products.push(random_product);
						}
					}
				}
			}
		}

		var mixed_product = mix_product(i);

		for (var cart = 0; cart < mixed_product.length; cart++) {
			var qty = random_integer(1, 4);
			await Models.cart.create({
				order_id: order[i].get('id'),
				product_id: mixed_product[cart].get('id'),
				name: mixed_product[cart].get('name'),
				quantity: qty,
				price: mixed_product[cart].get('price'),
				subtotal: (mixed_product[cart].get('price')*qty)
			});

			total_price[i] += (mixed_product[cart].get('price')*qty);
		}

		order[i].update({ total: total_price[i] });
	}
});

app.use(
	session,
	flash(),
	express.json(),
	express.urlencoded({ extended: true }),
	express.static(__dirname+'/public')
);
app.set('views', __dirname+'/views');
app.set('view engine', 'twig');
app.use(cors({ origin : (origin, callback) => { callback(null, true) }, credentials: true }));
app.use((req, res, next) => {
	res.locals.app = {
		name: 'NodeJs Simple App',
		vendor: 'Medan Software',
		version: 'v1.0.0'
	}

	res.render = (file, options = {}) => {
		Object.assign(options, res.locals); // merge option variable to local variable
		const Twig = new ViewEngine.Twig(__dirname+'/views'); // assign template paths

		// render with twig
		Twig.render(file, options, (error, output) => {
			if (error) {
				res.send(output);
			} else {
				res.send(output);
			}
		});
	}

	next();
});

const Middleware = {
	admin: async (req, res, next) => {
		if (req.originalUrl.match(/^\/admin(\/)?.*/)) {
			var auth_pages = /\/(sign-in|sign-up|forgot-password|recover-account|confirm-code)\/?/;
			if (typeof req.session.user_id == 'undefined') {
				if (req.originalUrl.match(auth_pages) == null) {
					req.flash('redirected', true);
					res.status(401);
					res.redirect('/admin/sign-in');
				} else {
					next();
				}
			} else {
				res.locals.user = await Models.user.findOne({
					where: {
						id: req.session.user_id
					}
				});
				if (req.originalUrl.match(auth_pages) !== null) {
					res.redirect('/admin');
				} else {
					next();
				}
			}
		} else {
			next();
		}
	}
}

app.get('/', (req, res) => {
	res.render('home.twig', {
		name: 'Developer'
	});
}).get('/about', (req, res) => {
	res.render('about.twig');
}).get('/contact', (req, res) => {
	res.render('contact.twig');
});

app.get('/admin', Middleware.admin, (req, res) => {
	res.render('admin/home.twig');
})
.get('/admin/sign-in', Middleware.admin, (req, res) => {
	res.render('admin/sign-in.twig');
})
.post('/admin/sign-in', Middleware.admin, async (req, res) => {
	var sha1 = require('crypto-js/sha1');
	var sign_in = await Models.user.findOne({
		where: {
			[DB.Op.or]: [
				{ email: req.body.identity },
				{ username: req.body.identity }
			],
			password: sha1(req.body.password).toString()
		}
	});

	if (sign_in !== null) {
		req.session.user_id = sign_in.id;
		req.flash('sign_in', true);
		res.redirect('/admin');
	} else {
		req.flash('redirected', true);
		res.status(401);
		res.redirect('/admin/sign-in');
	}
})
.get('/admin/profile', Middleware.admin, (req, res) => {
	res.render('admin/profile.twig');
})
.get('/admin/sign-out', Middleware.admin, (req, res) => {
	req.session.destroy((err) => {
		res.redirect('/admin/sign-in');
	});
});

http.listen(process.env.PORT || 8080);
