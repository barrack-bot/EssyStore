class Api {
    static async get(url) {
        try {
            const response = await fetch(url);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('API GET Error:', error);
            return { status: 'error', message: 'Network error' };
        }
    }

    static async post(url, data) {
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            return result;
        } catch (error) {
            console.error('API POST Error:', error);
            return { status: 'error', message: 'Network error' };
        }
    }
}
