# Natural Language Listing Feature

## Overview

The Telegram bot now supports creating listings using natural language input, a powerful alternative to the existing step-by-step wizard mode. Users can type their listings naturally, and the bot will automatically detect, parse, and prepare them for creation. This feature includes intelligent parsing, bulk creation capabilities, and a confirmation flow to ensure accuracy.

## How it Works

Users can type their listings in a single message without using special commands. The bot automatically detects when a message contains listing information, parses it, and presents a preview for the user to confirm.

The process is as follows:
1.  **Natural Input**: The user sends a message with one or more listings in a supported format.
2.  **Automatic Detection**: The bot identifies action keywords (e.g., "sell," "buy") and price patterns to recognize the message as a listing attempt.
3.  **Intelligent Parsing**: It extracts the item name, quantity, prices, and listing type for each line.
4.  **Preview and Confirm**: The bot displays a summary of the parsed listings, highlighting which are valid and which have errors (e.g., "item not found").
5.  **User Action**: The user can then confirm to create the valid listings, retry with corrected input, or cancel the operation.

## Supported Formats

### Basic Format
The fundamental structure for a single listing is:
`[action] [item name] [quantity] [price] [currency]`

### Action Keywords
The bot recognizes action keywords in both English and Russian.

**English:**
*   **Selling**: `sell`, `selling`, `wts`, `want to sell`, `have`
*   **Buying**: `buy`, `buying`, `wtb`, `want to buy`, `looking for`, `need`

**Russian:**
*   **Продажа (Selling)**: `продаю`, `продам`, `есть`, `имею`
*   **Покупка (Buying)**: `покупаю`, `куплю`, `ищу`, `нужен`, `нужна`, `нужно`

### Quantity Formats
Quantity can be specified in various ways, and if it's omitted, it defaults to `1`.

*   **Default to 1**: `sell item 200 QRK` → Creates a listing for **1** item.
*   **Smart Detection**: `sell item 5 300 QRK` → Creates a listing for **5** items.
*   **Explicit Formats**:
    *   `5x` or `5×`
    *   `x5` or `×5`
    *   `5шт` or `5шт.` (Russian for "pieces")
    *   `5pc` or `5pcs`
    *   `5-` or `5–` or `5—` (with a dash)
    *   `5 ` (a number followed by a space)

### Colon List Format
For clean, bulk-entry, users can group listings under a single action keyword using a colon. Each subsequent line inherits the action.
```
selling:
  Easter 100 QRK
  Leather patch 5 200 QRK
  Healing Potion 3 50 QRK

buying:
  Iron bracket 25 QRK
  Super Sword 1000 QRK
```

### Currency Support
Multiple currencies are supported and can be combined in a single listing.
*   **TON**: `ton`, `tonc`, `toncoin`
*   **QRK**: `qrk`, `quark`
*   **NOT**: `not`, `notcoin`
*   **USD**: `usd`, `usdt`, `dollar`

### Examples

**Single item listings:**
```
sell Iron Sword 5x 100 TON
buy Magic Potion - 10 - 50 QRK
selling Iron Boots 3 75 NOT
buying Health Potion 25 TON
```

**Multiple currencies:**
```
sell Legendary Shield 1 500 TON 250 QRK
sell Baron 3000 QRK 5 TON
```

**Multiple items (one per line):**
```
sell Iron Sword 5x 100 TON
sell Magic Shield 1 200 TON  
buy Health Potion x20 5 NOT
```

**Russian examples:**
```
продаю Железный меч 5x 100 TON
покупаю Магическое зелье 10 50 QRK
```

## Confirmation Flow

To prevent errors and give users full control, a confirmation flow is integrated into the process.

### 1. Parse and Preview
When a user sends their listings, the bot parses each line and presents a preview. Each listing is marked as valid (✅) or invalid (❌) with a clear reason for any failures.

```
🔍 Listing Preview

Please review the parsed listings below:

✅ 1. Sell iron sword (x5) - TON: 100
❌ 2. Buy nonexistent item (x1) - QRK: 50 (item not found)
✅ 3. Buy magic potion (x10) - QRK: 25, TON: 10

📊 Summary: 2 valid, 1 invalid, 3 total
```

### 2. User Confirmation
Below the preview, the user is given action buttons:
*   **✅ Create X Listings**: Creates only the valid listings.
*   **🔄 Try Again**: Discards the current attempt and prompts the user to send the listings again.
*   **❌ Cancel**: Cancels the entire operation.

### 3. Final Creation
The listings are only saved to the database after the user clicks the confirmation button.

## User Flow Examples

### Successful Flow
```
User: sell Iron Sword 5x 100 TON
Bot: 🔍 Listing Preview
     ✅ 1. Sell iron sword (x5) - TON: 100
     📊 Summary: 1 valid, 0 invalid, 1 total
     [Create 1 Listing] [Try Again] [Cancel]
User: *clicks Create 1 Listing*
Bot: ✅ Created 1 listings successfully. 0 failed.
```

### Error Detection Flow
```
User: sell Unknown Item 100 TON
Bot: 🔍 Listing Preview
     ❌ 1. Sell unknown item (x1) - TON: 100 (item not found)
     📊 Summary: 0 valid, 1 invalid, 1 total
     [Try Again] [Cancel]
User: *clicks Try Again*
Bot: 📝 Please send your listings again...
```
