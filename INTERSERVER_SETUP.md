# InterServer + wallet integration

The InterServer API credential must remain server-side and must never be committed to this public repository.

The integration uses InterServer's SOAP API. The official documentation states that `api_login(username, password)` uses the InterServer account username/email and accepts the API key as the password. VPS product pricing is exposed by `get_vps_slice_types()`, and license products by `api_get_license_types()`.

Set these on the server in `config.php` or environment variables:

- `INTERSERVER_USERNAME` = your InterServer account email
- `INTERSERVER_API_KEY` = your API key
- `INTERSERVER_MARKUP` = `1.00`

The dashboard adds exactly $1.00 to provider product cost before showing the customer price.

## Wallet

The wallet uses a locked balance row plus a transaction ledger. Purchases are debited atomically and insufficient balances are rejected.

`wallet_deposit.php` deliberately creates a **pending** deposit rather than crediting money from a browser POST. A verified payment-provider webhook must call `wallet_credit()` after payment verification. No payment-provider credentials were supplied, so automatically crediting deposits would be unsafe.

## VPS checkout

`wallet_buy.php` reserves the customer's wallet amount and creates a pending order. `vps_checkout.php` collects provisioning parameters and calls InterServer server-side. If provisioning fails while the order is still pending, the wallet amount is refunded and the order is marked failed.
