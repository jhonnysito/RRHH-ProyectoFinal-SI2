from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework import status
from .services.notification_service import NotificationService

class SendNotificationView(APIView):
    def post(self, request):
        token = request.data.get("token")
        title = request.data.get("title")
        message = request.data.get("message")

        if not token or not title or not message:
            return Response(
                {"error": "token, title y message son requeridos"},
                status=status.HTTP_400_BAD_REQUEST
            )

        try:
            success = NotificationService.send_notification(
                token=token,
                title=title,
                message=message
            )

            if success:
                return Response(
                    {"success": True, "message": "Notificación enviada"},
                    status=status.HTTP_200_OK
                )
            else:
                return Response(
                    {"error": "Error al enviar la notificación"},
                    status=status.HTTP_500_INTERNAL_SERVER_ERROR
                )
        except Exception as e:
            return Response({"error": str(e)}, status=status.HTTP_500_INTERNAL_SERVER_ERROR)
