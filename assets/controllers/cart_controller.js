import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['cartCount', 'cartTotal', 'itemRow'];

    add(event) {
        event.preventDefault();
        const url = event.currentTarget.href;

        fetch(url)
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => {
                this.cartCountTarget.innerHTML = data.count;
            })
            .catch(error => console.error('There has been a problem with your fetch operation:', error));
    }

    remove(event) {
        event.preventDefault();
        const url = event.currentTarget.href;

        fetch(url)
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => {
                this.cartCountTarget.innerHTML = data.count;
                this.cartTotalTarget.innerHTML = data.total + ' €';
                const itemRow = this.itemRowTargets.find(row => row.dataset.productId == data.productId);
                if (itemRow) {
                    itemRow.remove();
                }
            })
            .catch(error => console.error('There has been a problem with your fetch operation:', error));
    }
}
