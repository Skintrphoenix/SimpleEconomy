# EssentialsEconomy
Economy plugin for PocketMine-MP server.

## Commands
<table>
  <tr>
    <th>Command</th>
    <th>Subcommand</th>
    <th>Alias</th>
    <th>Description</th>
    <th>Usage</th>[/
  </tr>
  <tr>
    <td rowspan="4">economy</td>
    <td style="text-align: center">top</td>
    <td style="text-align: center">~</td>
    <td style="text-align: center">View top balances</td>
    <td style="text-align: center">economy top</td>
  </tr>
  <tr>
    <td style="text-align: center">add</td>
    <td style="text-align: center">give</td>
    <td style="text-align: center">Add player balance</td>
    <td style="text-align: center">economy add &lt;player&gt; &lt;amount&gt;</td>
  </tr>
  <tr>
    <td style="text-align: center">reduce</td>
    <td style="text-align: center">subtract</td>
    <td style="text-align: center">Reduce player balance</td>
    <td style="text-align: center">economy reduce &lt;player&gt; &lt;amount&gt;</td>
  </tr>
  <tr>
    <td style="text-align: center">set</td>
    <td style="text-align: center">~</td>
    <td style="text-align: center">Set player balance</td>
    <td style="text-align: center">economy set &lt;player&gt; &lt;amount&gt;</td>
  </tr>
  <tr>
    <td style="text-align: center">pay</td>
    <td style="text-align: center">~</td>
    <td style="text-align: center">~</td>
    <td style="text-align: center">Pay with your balance</td>
    <td style="text-align: center">pay &lt;player&gt; &lt;amount&gt;</td>
  </tr>
  <tr>
    <td style="text-align: center">reduce</td>
    <td style="text-align: center">~</td>
    <td style="text-align: center">~</td>
    <td style="text-align: center">Show player balance</td>
    <td style="text-align: center">balance &lt;player: optional&gt;</td>
  </tr>
</table>

## Examples API
### Show player balance
```php
EconomyAPI::balance(
player: "AraaCuteUwU",
onSuccess: static function (array $rows): void {
    echo $rows[0]['balance'];
},
onError: static function (SqlError $error): void {
    echo $error->getMessage();
});
```

### Add player balance
```php
EconomyAPI::add(
player: "AraaCuteUwU",
amount: 1000
onSuccess: static function (array $rows): void {
    echo "Balance updated";
},
onError: static function (SqlError $error): void {
    echo $error->getMessage();
});
```

### Subtract player balance
```php
EconomyAPI::subtract(
player: "AraaCuteUwU",
amount: 1000
onSuccess: static function (array $rows): void {
    echo "Balance updated";
},
onError: static function (SqlError $error): void {
    echo $error->getMessage();
});
```

### Set player balance
```php
EconomyAPI::set(
player: "AraaCuteUwU",
amount: 1000
onSuccess: static function (array $rows): void {
    echo "Balance updated";
},
onError: static function (SqlError $error): void {
    echo $error->getMessage();
});
```
## Note
This plugin is still under development and bugs can appear at any time. report bugs that occur in the [issue](https://github.com/AraaCuteUwU/SimpleEconomy/issues)