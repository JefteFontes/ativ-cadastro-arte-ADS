from rest_framework.decorators import api_view, permission_classes
from rest_framework.response import Response
from rest_framework import status
from rest_framework.permissions import IsAuthenticated
from .models import Art
from .serializers import ArtSerializer

@api_view(['GET', 'POST'])
@permission_classes([IsAuthenticated])
def ArtListCreateView(request):
    if request.method == 'GET':
        arts = Art.objects.all().order_by('-created_at')
        serializer = ArtSerializer(arts, many=True, context={'request': request})  # Adiciona contexto
        return Response(serializer.data)

    if request.method == 'POST':
        data = request.data.copy()
        data['user'] = request.user.id  # Garante que o usuário autenticado seja o dono da arte
        print(request.FILES)  # Depuração
        if 'image' not in request.FILES:
            return Response({'error': 'Imagem não recebida'}, status=status.HTTP_400_BAD_REQUEST)

        image = request.FILES['image']
        image.name = f"{request.user.id}_{image.name}"  # Evita nomes duplicados

        art = Art(user=request.user, image=image, caption=request.data.get('caption', ''))
        art.save()  # Salva manualmente

        serializer = ArtSerializer(art, context={'request': request})  # Passa contexto
        return Response(serializer.data, status=status.HTTP_201_CREATED)