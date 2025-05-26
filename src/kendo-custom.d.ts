declare namespace kendo.data {
    interface DataSource {
        // Hozzáadjuk a transport tulajdonságot a DataSource interfészhez.
        // A típus lehetne 'any' vagy egy pontosabb típus, ha tudjuk.
        transport: {
            options: {
                read: {
                    data: any; // A data tulajdonság típusa is 'any' lehet, ha dinamikus
                };
            };
            // Lehetnek itt más transport tulajdonságok is (pl. create, update, destroy)
        };
    }
}