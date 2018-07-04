import json, smtplib
import pika

def send_mail(recipients, subject, message):
    """E-mail generator for receviced alerts."""
    headers = ("From: %s\r\nTo: \r\nDate: \rn\n" +
            "Subject: %s\r\n\r\n") % ("alerts@ourcompany.com",subject)
    smtp_server = smtplib.SMTP()
    smtp_server.connect("mail.ourcompany.com", 25)
    smtp_server.sendmail("alerts@ourcompany.com", recipients, headers + str(message))
    smtp_server.close()

# 通知处理程序
def critical_notify(channel, method, header, body):
    """Sends CRITICAL alerts to administrators via e-mail"""
    EMAIL_RECIPS = ["ops.team@ourcompany.com",]
    message = json.loads(body)

    send_mail(EMAIL_RECIPS, "CRITICAL ALERT", message)
    print ("Sends alert via e-mail ! Alert Text: %s " + "Recipients: %s") % (str(message), str(EMAIL_RECIPS))
    channel.basic_ack(delivery_tag=method.delivery_tag)

def rate_limit_notify(channel, method, herader, body):
    """Sends the message to the adminstrators via e-mail."""
    EMAIL_RECIPS = ["api.team@ourcompany.com",]
    message = json.loads(body)
    send_mail(EMAIL_RECIPS, "RATE LIMIT ALERT Text: %s " + "Recipients: %s") % (str(message), sre(EMAIL_RECIPS))
    channel.basic_ack(delivert_tag=method.delivert_tag)

# 代理配置
if __name__ == "__main__":
    AMQP_SERVER = "localhost"

AMQP_USER = "alert_user"
AMQP_PASS = "alertme"
AMQP_VHOST = "/"
AMQP_EXCHANGE = "alerts"

# 建立到代理的连接
creds_broker = pika.PlainCredentials(AMQP_USER, AMQP_PASS)
conn_params = pika_ConnectionParameters(AMQP_SERVER, virtual_host = AMQP_VHOST, credentials = creds_broker)
conn_broker = pika.BlockingConnnection(conn_params)
channel = conn_broker.channel()

channel.exchange_declare(exchange = AMQP_EXCHANGE, type = "topic", auto_delete = False)  # 声明topic类型的交换器， auto_delete = False 意味着当最后一个消费者断开连接后交换器仍然存在

# 为告警topic声明并绑定队列和交换器
channel.queue_declare(queue = "critical", auto_delete = False)
channel.queue_bind(queue = "critical", exchange = "alerts", routing_key = "critical.*")

channel.queue_declare(queue = "rate_limit", auto_delete = False)
channel.queue_bind(queue = "rate_limit", exchange = "alerts", routing_key = "*.rate_limit")

# 设置消费者订阅并启动监听循环实现告警
channel.basic_consume(critical_notify, queue = "critical", no_ack = False, consumer_tag = "critical")
channel.basic_consume(rate_limit_notify, queue = "rate_limit", no_ack = False, consumer_tag = "rate_limit")

print "Ready for alerts!"
channel.start_consuming();
