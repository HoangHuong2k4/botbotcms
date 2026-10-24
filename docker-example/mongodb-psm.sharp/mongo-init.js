db.createUser(
    {
        user: "sharp_saleman",
        pwd: "zyq*F6qN3vzAqIF8",
        roles: [
            {
                role: "readWrite",
                db: "sharp_saleman"
            }
        ]
    }
);
db.createCollection("admin"); 