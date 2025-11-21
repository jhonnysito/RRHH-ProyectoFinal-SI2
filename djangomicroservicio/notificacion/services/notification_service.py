import requests
import google.auth.transport.requests
from google.oauth2 import service_account
from django.conf import settings

class NotificationService:

    @staticmethod
    def _get_access_token():
        """
        Genera token OAuth2 válido para FCM v1
        """
        SCOPES = ["https://www.googleapis.com/auth/firebase.messaging"]

        credentials = service_account.Credentials.from_service_account_file(
            settings.FCM_CREDENTIALS_FILE,
            scopes=SCOPES
        )

        request = google.auth.transport.requests.Request()
        credentials.refresh(request)

        return credentials.token

    @staticmethod
    def send_notification(token, title, message):
        """
        Envía notificación push a Firebase Cloud Messaging
        """
        access_token = NotificationService._get_access_token()

        url = f"https://fcm.googleapis.com/v1/projects/{settings.FCM_PROJECT_ID}/messages:send"

        payload = {
            "message": {
                "token": token,
                "notification": {
                    "title": title,
                    "body": message
                }
            }
        }

        headers = {
            "Authorization": f"Bearer {access_token}",
            "Content-Type": "application/json; UTF-8"
        }

        response = requests.post(url, headers=headers, json=payload)

        # Para debug
        print("FCM response:", response.text)

        return response.status_code == 200
