module.exports = function(DataTypes) {
	return {
		fields: {
			id: {
				type: DataTypes.INTEGER(2),
				primaryKey: true,
				autoIncrement: true
			},
			type: {
				type: DataTypes.ENUM('drink', 'food'),
				allowNull: false
			},
			name: {
				type: DataTypes.STRING,
				allowNull: false
			},
			image: {
				type: DataTypes.STRING,
				allowNull: true
			},
			price: {
				type: DataTypes.DOUBLE,
				allowNull: true
			}
		},
		config: {
			timestamps: false
		}
	}
}
