import requests
from pyrogram.types import InlineKeyboardMarkup, InlineKeyboardButton
from pyrogram.errors import UserNotParticipant 
from os import getenv
from pyrogram import Client, filters
from googletrans import Translator

bot = Client("Chatbot", 
                bot_token=getenv("BOT_TOKEN"), 
                api_id=getenv("API_ID"), 
                api_hash=getenv("API_HASH"))

tr = Translator()

@bot.on_message(filters.command("start"))      
async def startmsg(_, message):
    await message.reply_video(video="https://telegra.ph/file/b8f0cbdf67943328459d2.mp4", 
    caption=f"Hello {message.chat.id}. \nI'm AI Chat bot made by Tinura Dinith by Using Affiliateplus API, You can chat with me here.")

@bot.on_message(
    filters.text 
    & filters.private 
    & ~filters.edited 
    & ~filters.bot 
    & ~filters.channel 
    & ~filters.forwarded,
    group=1)
async def chatbot(_, message):
    if message.text[0] == "/":
        return
    await bot.send_chat_action(message.chat.id, "typing")
    lang = tr.translate(message.text).src
    trtoen = (message.text if lang=="en" else tr.translate(message.text, dest="en").text).replace(" ", "%20")
    text = trtoen.replace(" ", "%20") if len(message.text) < 2 else trtoen
    newyork = ("{text}")
    textmsg = (newyork.json()["message"])
    msg = tr.translate(textmsg, src='en', dest=lang)
    await message.reply_text(msg.text)

bot.run()    
