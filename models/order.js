module.exports = function(DataTypes) {
	return {
		fields: {
			id: {
				type: DataTypes.INTEGER(4),
				primaryKey: true,
				autoIncrement: true
			},
			uid: {
				type: DataTypes.STRING(10),
				allowNull: false
			},
			item: {
				type: DataTypes.INTEGER(1),
				allowNull: true
			},
			total: {
				type: DataTypes.DOUBLE,
				allowNull: true
			},
			date: {
				type: DataTypes.DATEONLY,
				allowNull: false
			},
			time: {
				type: DataTypes.TIME,
				allowNull: false
			}
		},
		config: {
			timestamps: false
		}
	}
}
