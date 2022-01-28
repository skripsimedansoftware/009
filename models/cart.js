module.exports = function(DataTypes) {
	return {
		fields: {
			id: {
				type: DataTypes.INTEGER(4),
				primaryKey: true,
				autoIncrement: true
			},
			order_id: {
				type: DataTypes.INTEGER(4),
				allowNull: false
			},
			product_id: {
				type: DataTypes.INTEGER(2),
				allowNull: false
			},
			name: {
				type: DataTypes.STRING(80),
				allowNull: false
			},
			quantity: {
				type: DataTypes.INTEGER(2),
				allowNull: false
			},
			price: {
				type: DataTypes.DOUBLE,
				allowNull: false
			},
			subtotal: {
				type: DataTypes.DOUBLE,
				allowNull: false
			}
		},
		config: {
			timestamps: false
		}
	}
}
